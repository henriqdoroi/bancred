# 🧪 Como Testar a ReceitaWS

## ✅ Configuração Completa!

A ReceitaWS já está configurada no arquivo `consulta/cpf.php`.

## 📋 O que foi configurado:

1. ✅ Função `consultarReceitaWS()` ativada
2. ✅ Tratamento de erros implementado
3. ✅ Validação de resposta da API
4. ✅ Timeout configurado (15 segundos)
5. ✅ Logs de erro para debug

## 🚀 Como Testar:

### **Opção 1: Testar pelo Navegador (Frontend)**

1. Abra o arquivo `cpf.html` no navegador
2. Digite um CPF válido (ex: 12345678909)
3. Clique em "Continuar"
4. Deve mostrar a tela de análise e depois redirecionar

### **Opção 2: Testar a API Diretamente**

#### No Windows PowerShell:
```powershell
# Teste com CPF de exemplo
$body = @{cpf="12345678909"} | ConvertTo-Json
Invoke-RestMethod -Uri "http://localhost/consulta/cpf.php" -Method POST -Body $body -ContentType "application/json"
```

#### No Linux/Mac (Terminal):
```bash
curl -X POST http://localhost/consulta/cpf.php \
  -H "Content-Type: application/json" \
  -d '{"cpf":"12345678909"}'
```

### **Opção 3: Testar Online (se já estiver em produção)**

Se seu site já estiver online, teste com:
```
https://seu-dominio.com/consulta/cpf.php
```

## ⚠️ Limitações da ReceitaWS:

- **Máximo 3 consultas por minuto por IP**
- Se exceder, receberá erro 429 (Too Many Requests)
- Aguarde 1 minuto antes de tentar novamente

## 🔍 Verificar se está funcionando:

### Resposta de Sucesso:
```json
{
  "success": true,
  "data": {
    "cpf": "12345678909",
    "nome": "Nome da Pessoa",
    "nascimento": "1990-01-01",
    "situacao": "Regular",
    "status": "aprovado",
    "fonte": "ReceitaWS"
  }
}
```

### Resposta de Erro:
```json
{
  "success": false,
  "message": "Não foi possível consultar o CPF..."
}
```

## 🐛 Troubleshooting:

### **Erro: "API não disponível"**
- Verifique se o PHP está rodando
- Verifique se a extensão cURL está habilitada
- Verifique permissões do arquivo

### **Erro: "Timeout"**
- A ReceitaWS pode estar lenta
- Aumente o timeout no código (linha ~87)

### **Erro: "Too Many Requests"**
- Você excedeu o limite de 3 consultas/minuto
- Aguarde 1 minuto e tente novamente

### **Erro: "CPF não encontrado"**
- A ReceitaWS pode não ter dados desse CPF
- Tente com outro CPF válido

## 📝 Próximos Passos:

1. ✅ Teste localmente
2. ✅ Verifique se os dados estão sendo retornados
3. ✅ Teste no frontend (cpf.html)
4. ✅ Faça deploy em produção

## 💡 Dica:

Para testar sem usar consultas reais, você pode comentar a linha:
```php
$resultado = consultarReceitaWS($cpf);
```
E descomentar as linhas de dados simulados temporariamente.



