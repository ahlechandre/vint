<?php

return [

    // -----------------------------------------------------
    // Grupos.
    // -----------------------------------------------------
    'groups' => [
        // Apagar.
        'delete_title' => 'Apagar o grupo?',
        'delete_body' => 'Todos os seus projetos e programas também serão apagados. Esta ação é permanente.',
        // Remover membro do grupo.
        'detach_member_title' => 'Remover o membro do grupo?',
        'detach_member_body' => 'Ele não aparecerá mais na lista de membros e nem poderá associar os recursos do grupo em seus novos produtos e publicações.', 
    ],

    // -----------------------------------------------------
    // Solicitações de membros.
    // -----------------------------------------------------
    'members_requests' => [
        // Aprovar.
        'approve_all_title' => 'Aprovar todos os :count membros?',
        'approve_all_body' => 'Todos os aprovados aparecerão na lista de membros do grupo e poderão manter os recursos do grupo de acordo com as permissões dos seus papéis.',
        'approve_title' => 'Aprovar o membro?',
        'approve_body' => ':name aparecerá na lista de membros do grupo e poderá manter os recursos do grupo de acordo com as permissões do seu papel.',
        // Recusar. 
        'deny_all_title' => 'Recusar todos os :count membros?',
        'deny_title' => 'Recusar o membro?',
    ],

    // -----------------------------------------------------
    // Solicitações de projetos.
    // -----------------------------------------------------    
    'projects_requests' => [
        // Aprovar.
        'approve_all_title' => 'Aprovar todos os :count projetos?',
        'approve_all_body' => 'Todos os aprovados aparecerão na lista de projetos do grupo e poderão ser mantidos pelos membros.',
        'approve_title' => 'Aprovar ":name"?',
        'approve_body' => 'Ele aparecerá na lista de projetos do grupo e poderá ser mantido pelos membros.',
        // Recusar. 
        'deny_all_title' => 'Recusar todos os :count projetos?',
        'deny_title' => 'Recusar ":name"?',
    ],

    // -----------------------------------------------------
    // Solicitações de programas.
    // -----------------------------------------------------    
    'programs_requests' => [
        // Aprovar.
        'approve_all_title' => 'Aprovar todos os :count programas?',
        'approve_all_body' => 'Todos os aprovados aparecerão na lista de programas do grupo e poderão ser mantidos pelos membros.',
        'approve_title' => 'Aprovar ":name"?',
        'approve_body' => 'Ele aparecerá na lista de programas do grupo e poderá ser mantido pelos membros.',
        // Recusar. 
        'deny_all_title' => 'Recusar todos os :count programas?',
        'deny_title' => 'Recusar ":name"?',
    ],

    // -----------------------------------------------------
    // Coordenadores.
    // -----------------------------------------------------    
    'coordinators' => [
        // Novo coordenador.
        'create_title' => 'Novo coordenador.',
        'create_body' => 'O membro terá permissão máxima no grupo.',
        // Editar coordenador.
        'edit_title' => 'Editar coordenador.',
        // Remover coordenador.
        'remove_title' => 'Remover coordenador?',        
        'remove_body' => 'O membro não aparecerá na lista de coordenadores mas continua participando do grupo.',
    ],

    // -----------------------------------------------------
    // Membros.
    // -----------------------------------------------------    
    'members' => [
        // Enviar participação.
        'request_group_title' => 'Solicitar participação no grupo?',
        'request_group_body' => 'Uma solicitação será enviada ao grupo e os membros responsáveis irão analisá-la.
        
        Você poderá cancelar esta solicitação a qualquer momento.',
        // Cancelar participação.
        'request_group_cancel_title' => 'Cancelar a solicitação enviada ao grupo?',
        'request_group_cancel_body' => 'A solicitação de participação enviada será cancelada e você não fará parte do grupo.',
        // Deixar o grupo.
        'leave_group_title' => 'Deixar o grupo?',
        'leave_group_body' => 'Você não aparecerá mais na lista de membros do grupo e nem poderá associar os recursos dele em novos produtos e publicações.',
        // Atualizar papel.
        'update_role_title' => 'Definir seu papel como :name',
        'update_role_body' => 'Indique as informações específicas do papel.',
    ],

    // -----------------------------------------------------
    // Programas.
    // -----------------------------------------------------    
    'programs' => [
        // Apagar.
        'delete_title' => 'Apagar o programa?',
        'delete_body' => 'Todos os projetos relacionados a ele continuarão existindo sem programa. Esta ação é permanente.',
    ],

    // -----------------------------------------------------
    // Projetos.
    // -----------------------------------------------------    
    'projects' => [
        // Apagar.
        'delete_title' => 'Apagar o projeto?',
        'delete_body' => 'Todos os produtos e publicações relacionados permanecerão sem este projeto. Esta ação é permanente.',
    ],

    // -----------------------------------------------------
    // Produtos.
    // -----------------------------------------------------    
    'products' => [
        // Apagar.
        'delete_title' => 'Apagar o produto?',
    ],

    // -----------------------------------------------------
    // Publicações.
    // -----------------------------------------------------    
    'publications' => [
        // Apagar.
        'delete_title' => 'Apagar a publicação?',
    ],
];