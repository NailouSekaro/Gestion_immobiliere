<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 12px;
            line-height: 1.5;
        }

        .header {
            border-bottom: 3px solid #1f86ff;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }

        .title {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 6px;
        }

        .muted {
            color: #64748b;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            border-bottom: 1px solid #dbeafe;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 6px 0;
            vertical-align: top;
        }

        .label {
            width: 34%;
            font-weight: 700;
            color: #334155;
        }

        .box {
            border: 1px solid #cbd5e1;
            padding: 12px;
            border-radius: 6px;
            background: #f8fafc;
        }

        .signatures {
            margin-top: 52px;
        }

        .signature-cell {
            width: 50%;
            text-align: center;
            padding-top: 46px;
        }

        .signature-line {
            border-top: 1px solid #0f172a;
            display: inline-block;
            width: 220px;
            padding-top: 8px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 class="title">Contrat de location</h1>
        <div class="muted">Numero : {{ $contract->numero_contrat }}</div>
    </div>

    <div class="section">
        <div class="section-title">Informations du contrat</div>
        <table>
            <tr>
                <td class="label">Statut</td>
                <td>{{ ucfirst($contract->statut) }}</td>
            </tr>
            <tr>
                <td class="label">Periode</td>
                <td>{{ $contract->date_debut->format('d/m/Y') }} au {{ $contract->date_fin->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Duree</td>
                <td>{{ $contract->duree_mois }} mois</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Locataire</div>
        <table>
            <tr>
                <td class="label">Nom complet</td>
                <td>{{ $contract->user->prenom }} {{ $contract->user->nom }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td>{{ $contract->user->email }}</td>
            </tr>
            <tr>
                <td class="label">Telephone</td>
                <td>{{ $contract->user->telephone ?? 'Non renseigne' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Chambre / propriete</div>
        <table>
            <tr>
                <td class="label">Designation</td>
                <td>{{ $contract->property->nom ?: 'Propriete #' . $contract->property->id }}</td>
            </tr>
            <tr>
                <td class="label">Adresse</td>
                <td>{{ $contract->property->adresse }}</td>
            </tr>
            <tr>
                <td class="label">Ville</td>
                <td>{{ $contract->property->ville }}</td>
            </tr>
            <tr>
                <td class="label">Details</td>
                <td>{{ $contract->property->nombre_pieces }} piece(s), {{ $contract->property->surface }} m2</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Conditions financieres</div>
        <table>
            <tr>
                <td class="label">Loyer mensuel</td>
                <td>{{ number_format($contract->loyer_mensuel, 0, ',', ' ') }} {{ $contract->devise }}</td>
            </tr>
            <tr>
                <td class="label">Caution</td>
                <td>{{ number_format($contract->caution, 0, ',', ' ') }} {{ $contract->devise }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Termes</div>
        <div class="box">
            {{ $contract->termes ?: "Le locataire s'engage a occuper les lieux paisiblement, a regler le loyer aux echeances convenues et a respecter les conditions de location etablies par l'administration." }}
        </div>
    </div>

    <table class="signatures">
        <tr>
            <td class="signature-cell">
                <span class="signature-line">Signature du locataire</span>
            </td>
            <td class="signature-cell">
                <span class="signature-line">Signature de l'administration</span>
            </td>
        </tr>
    </table>
</body>

</html>
