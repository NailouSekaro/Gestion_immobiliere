<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'conversation_id',
        'expediteur_id',
        'destinataire_id',
        'sujet',
        'contenu',
        'type',
        'lu',
        'lu_le',
        'delivered_at',
        'piece_jointe',
        'reply_to_id'
    ];

    protected $casts = [
        'lu' => 'boolean',
        'lu_le' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($message) {
            $message->uuid = Str::uuid();

            // Générer automatiquement un conversation_id
            if (!$message->conversation_id) {
                $message->conversation_id = self::generateConversationId(
                    $message->expediteur_id,
                    $message->destinataire_id
                );
            }
        });
    }

    // Générer un ID de conversation unique entre deux utilisateurs
    public static function generateConversationId($user1Id, $user2Id)
    {
        $ids = [$user1Id, $user2Id];
        sort($ids);
        return 'conv_' . implode('_', $ids);
    }

    // Relations
    public function expediteur()
    {
        return $this->belongsTo(User::class, 'expediteur_id')->withTrashed();
    }

    public function destinataire()
    {
        return $this->belongsTo(User::class, 'destinataire_id')->withTrashed();
    }

    public function replyTo()
    {
        return $this->belongsTo(Message::class, 'reply_to_id');
    }

    // Scopes
    public function scopeNonLus($query)
    {
        return $query->where('lu', false);
    }

    public function scopePourDestinataire($query, $userId)
    {
        return $query->where('destinataire_id', $userId);
    }

    public function scopeParExpediteur($query, $userId)
    {
        return $query->where('expediteur_id', $userId);
    }

    public function scopeConversation($query, $conversationId)
    {
        return $query->where('conversation_id', $conversationId)
                    ->orderBy('created_at', 'asc');
    }

    // Récupérer toutes les conversations d'un utilisateur
    public static function getUserConversations($userId)
    {
        return self::where(function($query) use ($userId) {
                $query->where('expediteur_id', $userId)
                      ->orWhere('destinataire_id', $userId);
            })
            ->select('conversation_id',
                    \DB::raw('MAX(created_at) as last_message_at'),
                    \DB::raw('MAX(id) as last_message_id'))
            ->groupBy('conversation_id')
            ->orderBy('last_message_at', 'desc')
            ->get()
            ->map(function($conv) use ($userId) {
                $lastMessage = self::find($conv->last_message_id);
                $otherUserId = $lastMessage->expediteur_id === $userId
                    ? $lastMessage->destinataire_id
                    : $lastMessage->expediteur_id;

                return [
                    'conversation_id' => $conv->conversation_id,
                    'other_user' => User::withTrashed()->find($otherUserId),
                    'last_message' => $lastMessage,
                    'unread_count' => self::where('conversation_id', $conv->conversation_id)
                                        ->where('destinataire_id', $userId)
                                        ->where('lu', false)
                                        ->count()
                ];
            });
    }

    // Méthodes utilitaires
    public function marquerCommeLu()
    {
        $this->update([
            'lu' => true,
            'lu_le' => now()
        ]);
    }

    public function peutVoir($userId)
    {
        return $this->expediteur_id === $userId || $this->destinataire_id === $userId;
    }

    public function getPieceJointeUrlAttribute()
    {
        return $this->piece_jointe ? Storage::url($this->piece_jointe) : null;
    }

    // Récupérer l'autre utilisateur de la conversation
    public function getOtherUser($currentUserId)
    {
        return $this->expediteur_id === $currentUserId
            ? $this->destinataire
            : $this->expediteur;
    }
}
