# Como Configurar a API de Consulta CPF

## 📋 O que você precisa fazer:

### 1. **Estrutura de Arquivos**
O arquivo `consulta/cpf.php` já foi criado. Certifique-se de que está na estrutura correta:
```
bancred.site/
├── consulta/
│   └── cpf.php  ← API backend
├── cpf.html     ← Frontend
└── ...
```

### 2. **Configurar o Backend PHP**

Abra o arquivo `consulta/cpf.php` e escolha uma das opções abaixo:

#### **OPÇÃO 1: ReceitaWS (Gratuita, mas limitada)**
- Descomente a função `consultarReceitaWS()`
- Descomente a linha: `$resultado = consultarReceitaWS($cpf);`
- ⚠️ Limitação: Apenas 3 consultas por minuto

#### **OPÇÃO 2: Serasa API (Paga, completa)**
- Descomente a função `consultarSerasa()`
- Adicione sua API Key da Serasa
- Descomente a linha: `$resultado = consultarSerasa($cpf);`
- 💰 Requer plano pago

#### **OPÇÃO 3: Banco de Dados Próprio**
- Descomente a função `consultarBancoDados()`
- Configure conexão com MySQL/PostgreSQL
- Crie tabela `usuarios` com campos: cpf, nome, email, status
- Descomente a linha: `$resultado = consultarBancoDados($cpf);`

### 3. **Requisitos do Servidor**

- PHP 7.4 ou superior
- Extensão cURL habilitada (para APIs externas)
- Extensão PDO habilitada (se usar banco de dados)
- Servidor web (Apache/Nginx)

### 4. **Testar a API**

Você pode testar a API diretamente:

```bash
curl -X POST http://localhost/consulta/cpf.php \
  -H "Content-Type: application/json" \
  -d '{"cpf":"12345678909"}'
```

### 5. **Estrutura de Resposta Esperada**

A API deve retornar:
```json
{
  "success": true,
  "data": {
    "cpf": "12345678909",
    "nome": "Nome da Pessoa",
    "status": "aprovado",
    "situacao": "Regular",
    "nascimento": "1990-01-01"
  }
}
```

### 6. **Segurança**

⚠️ **IMPORTANTE**: 
- Remova o modo de desenvolvimento (dados simulados) quando colocar em produção
- Configure CORS adequadamente
- Use HTTPS em produção
- Valide e sanitize todos os inputs
- Implemente rate limiting
- Use autenticação se necessário

### 7. **Alternativas de APIs de Consulta CPF**

- **ReceitaWS**: https://www.receitaws.com.br/ (Gratuita, limitada)
- **Serasa API**: https://developers.serasa.com.br/ (Paga, completa)
- **BrasilAPI**: https://brasilapi.com.br/ (Gratuita, limitada)
- **CPF API**: https://cpfapi.com.br/ (Paga)

### 8. **Troubleshooting**

**Erro 404**: Verifique se o arquivo está em `consulta/cpf.php`
**Erro 500**: Verifique logs do PHP e permissões do arquivo
**CORS Error**: Configure headers CORS no PHP
**Timeout**: Aumente o timeout do cURL nas funções

### 9. **Próximos Passos**

1. Escolha uma API de consulta CPF
2. Configure as credenciais no `cpf.php`
3. Teste localmente
4. Remova dados simulados
5. Faça deploy em produção



