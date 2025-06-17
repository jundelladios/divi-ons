<?php

$dmnservices = carbon_get_theme_option('ponds_domain_services');
$domainconfigs = [];
foreach( $dmnservices as $dmn ) {
    $domainconfigs[$dmn['pond_domain_service_domain']] = [
        'services_pages_title' => $dmn['pond_domain_service_title']
    ];
}