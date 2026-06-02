// Script para capturar e salvar UTMs em todas as páginas
// Este script deve ser carregado ANTES de qualquer redirecionamento

(function() {
    'use strict';
    
    // Função para extrair parâmetros da URL
    function getUrlParams() {
        const params = new URLSearchParams(window.location.search);
        const utmParams = {};
        const allParams = {};
        
        // Capturar todos os parâmetros UTM e de tracking
        params.forEach((value, key) => {
            allParams[key] = value;
            const keyLower = key.toLowerCase();
            
            // Capturar parâmetros UTM padrão
            if (keyLower.startsWith('utm_') || 
                keyLower === 'gclid' || 
                keyLower === 'fbclid' ||
                keyLower === 'ref' ||
                keyLower === 'source' ||
                keyLower === 'campaign_id' ||
                keyLower === 'ad_id' ||
                keyLower === 'adset_id') {
                utmParams[key] = value;
            }
        });
        
        return { 
            utmParams, 
            allParams, 
            queryString: window.location.search 
        };
    }
    
    // Executar imediatamente ao carregar
    const { utmParams, allParams, queryString } = getUrlParams();
    
    // Se tiver UTMs na URL, salvar (prioriza URL sobre sessionStorage)
    if (Object.keys(utmParams).length > 0 || queryString) {
        sessionStorage.setItem('utmParams', JSON.stringify(utmParams));
        sessionStorage.setItem('trackingParams', queryString);
        sessionStorage.setItem('allUrlParams', JSON.stringify(allParams));
        
        console.log('✅ [UTM Capture] UTMs capturadas e salvas:', utmParams);
        console.log('✅ [UTM Capture] Query string completa:', queryString);
    } else {
        // Se não tiver na URL, tentar recuperar do sessionStorage
        const savedUtms = sessionStorage.getItem('utmParams');
        const savedQuery = sessionStorage.getItem('trackingParams');
        
        if (savedUtms || savedQuery) {
            console.log('ℹ️ [UTM Capture] UTMs recuperadas do sessionStorage');
            console.log('ℹ️ [UTM Capture] UTMs:', savedUtms);
            console.log('ℹ️ [UTM Capture] Query:', savedQuery);
        } else {
            console.log('⚠️ [UTM Capture] Nenhuma UTM encontrada na URL ou sessionStorage');
        }
    }
    
    // Função auxiliar para obter parâmetros de tracking (usada em outras páginas)
    window.getTrackingParams = function() {
        const savedQuery = sessionStorage.getItem('trackingParams');
        return savedQuery || '';
    };
    
    // Função auxiliar para obter UTMs (usada em outras páginas)
    window.getUtmParams = function() {
        const savedUtms = sessionStorage.getItem('utmParams');
        return savedUtms ? JSON.parse(savedUtms) : {};
    };
})();

