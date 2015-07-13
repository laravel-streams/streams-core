<?php

return [
    '403'                 => 'Accès refusé.',
    '503'                 => 'Bientôt de retour.',
    '404'                 => 'Page introuvable.',
    '500'                 => 'Il y a eu une erreur.',
    'no_results'          => 'Aucun résultat.',
    'no_fields_available' => 'Aucun champs disponible.',
    'delete_success'      => ':count entrée(s) supprimée(s) avec succès.',
    'reorder_success'     => ':count entrée(s) ordonnée(s) avec succès.',
    'csrf_token_mismatch' => 'Votre jeton de sécurité a expiré. Veuillez valider le formulaire à nouveau.',
    'delete_installer'    => 'Le module d\'installation est encore présent ! Veuillez le supprimer. En le laissant n\'importe qui pourra prendre le contrôle du site.<br><br><strong>' . link_to(
            'admin/addons/modules/delete/anomaly.module.installer',
            'Cliquez ici pour le supprimer.'
        ) . '</strong>',
    'create_success'      => ':name créé avec succès.',
    'edit_success'        => ':name modifié avec succès.',
    'confirm_delete'      => 'Etes-vous sûr de vouloir supprimer ?<br><small>Pas de retour en arrière possible.</small>',
    'prompt_delete'       => 'Etes-vous sûr de voiloir supprimer ?<br><small>Entrez \"yes\" pour confirmer.</small>',
];
