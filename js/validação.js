// Validação para o input "E-mail".
const inputEmail = document.getElementById('email');

inputEmail.addEventListener('input', function() {
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!emailRegex.test(this.value)) {
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    }
});

// Validação para o input "Nome Completo".
const inputName = document.getElementById('name');

inputName.addEventListener('input', function() {
if (this.value.length < 15 || this.value.length > 80) {
    this.classList.remove('is-valid');
    this.classList.add('is-invalid');
} else {
    this.classList.remove('is-invalid');
    this.classList.add('is-valid');
}

});

// Validação para o input "Data de Nascimento".
const inputData = document.getElementById('data_nasc');

inputData.addEventListener('input', function() {
    const data = new Date(this.value);
    const dataAtual = new Date();
    const dataMinima = new Date();
    dataMinima.setFullYear(1940, 0, 1);

    if (data > dataAtual || data < dataMinima) {
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    }
});


// Validação para o input "Nome da Mãe".
const inputMae = document.getElementById('mae');

inputMae.addEventListener('input', function() {
    if (this.value.length < 15 || this.value.length > 80) {
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    }
});

// Função para formatar o CPF no formato (xxx.xxx.xxx-xx)
function formatarCPF(cpf) {
    return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
}

// Função para validar CPF
function validarCPF(cpf) {
    // Remover caracteres não numéricos
    cpf = cpf.replace(/\D/g, '');

    // Verificar se todos os dígitos são iguais
    if (/(\d)\1{10}/.test(cpf)) {
        return false;
    }

    // Verificar se o CPF tem 11 dígitos
    if (cpf.length !== 11) {
        return false;
    }

    // Calcular primeiro dígito verificador
    let soma = 0;
    for (let i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }
    let resto = 11 - (soma % 11);
    let digito1 = (resto >= 10) ? 0 : resto;

    // Verificar primeiro dígito verificador
    if (digito1 != parseInt(cpf.charAt(9))) {
        return false;
    }

    // Calcular segundo dígito verificador
    soma = 0;
    for (let i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }
    resto = 11 - (soma % 11);
    let digito2 = (resto >= 10) ? 0 : resto;

    // Verificar segundo dígito verificador
    if (digito2 != parseInt(cpf.charAt(10))) {
        return false;
    }

    return true;
}

// Função para verificar se há números iguais em sequência
function temNumerosRepetidos(numero) {
    return /^(.)\1+$/.test(numero);
}

// Adicione um listener de evento de input ao campo CPF
document.getElementById('cpf').addEventListener('input', function(event) {
    let cpf = this.value.replace(/\D/g, ''); // Remove caracteres não numéricos

    // Formatar CPF no formato (191.761.947-28)
    this.value = formatarCPF(cpf);

    // Verificar se o CPF é válido
    if (!validarCPF(cpf)) {
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');
    } else if (temNumerosRepetidos(cpf)) {
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    }
});

// Adicione um listener de evento de input ao campo celular
document.getElementById('celular').addEventListener('input', function(event) {
    let celular = this.value.replace(/\D/g, ''); // Remove caracteres não numéricos
    let formattedCelular = formatarCelular(celular); // Formata o número de celular
    
    // Atualiza o valor do campo com o número formatado
    this.value = formattedCelular;
    
    // // Verifica se o número de celular possui 11 dígitos
    // if (celular.length !== 11) {
    //     this.classList.remove('is-valid');
    //     this.classList.add('is-invalid');
    //     return; // Retorna imediatamente se o número de dígitos não for igual a 11
    // }
    
    // // Verifica se o número de celular possui números repetidos
    // if (temNumerosRepetidos(celular)) {
    //     this.classList.remove('is-valid');
    //     this.classList.add('is-invalid');
    // } else {
    //     this.classList.remove('is-invalid');
    //     this.classList.add('is-valid');
    // }
    });
    
    // Função para formatar o número de celular
    function formatarCelular(numero) {
        // Adiciona os parênteses e o hífen conforme o formato (XX) XXXXX-XXXX
        return numero.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2 $3');
    }
    
    // // Função para verificar se o número de celular possui números repetidos
    // function temNumerosRepetidos(numero) {
    //     // Verifica se todos os dígitos do número de celular são iguais
    //     return /^(.)\1+$/.test(numero);
    // }
    
// Comando de busca do cep no API do Correios:
document.getElementById('cep').addEventListener('blur', function() {
    const cep = this.value.replace(/\D/g, ''); // Remove caracteres não numéricos

    // Verifica se o cep possui 8 dígitos
    if (cep.length === 8) {
        // Faz uma requisição para a API dos Correios
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    // Preenche os campos com os dados retornados pela API
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('municipio').value = data.localidade;
                    document.getElementById('estado').value = data.uf;
                    document.getElementById('endereco').value = data.logradouro;

                    // Chama a função de validação para cada campo preenchido
                    validarCampoTexto(document.getElementById('bairro'), 2, 50);
                    validarCampoTexto(document.getElementById('municipio'), 2, 50);
                    validarCampoTexto(document.getElementById('estado'), 2, 2);
                    validarCampoTexto(document.getElementById('endereco'), 5, 100);
                } else {
                    // Se o cep não for encontrado, define os campos como inválidos
                    document.getElementById('bairro').classList.remove('is-valid');
                    document.getElementById('bairro').classList.add('is-invalid');
                    document.getElementById('municipio').classList.remove('is-valid');
                    document.getElementById('municipio').classList.add('is-invalid');
                    document.getElementById('estado').classList.remove('is-valid');
                    document.getElementById('estado').classList.add('is-invalid');
                    document.getElementById('endereco').classList.remove('is-valid');
                    document.getElementById('endereco').classList.add('is-invalid');

                    alert('cep não encontrado.');
                }
            })
            .catch(error => console.error('Erro ao consultar o cep:', error));
    }
});

// Função para validar campos de texto
function validarCampoTexto(campo, min, max) {
    const valor = campo.value.trim();
    const isValid = valor.length >= min && valor.length <= max;
    if (isValid) {
        campo.classList.remove('is-invalid');
        campo.classList.add('is-valid');
        return true;
    } else {
        campo.classList.remove('is-valid');
        campo.classList.add('is-invalid');
        return false;
    }
}

// Função para validar o cep
function validarCep(cep) {
    // Adicione aqui a lógica de validação do cep, se necessário
    // Por exemplo, você pode verificar se o cep possui o formato correto
    // e retornar true ou false conforme necessário
    return cep.length === 8 && /^[0-9]+$/.test(cep);
}

// Função para preencher automaticamente os campos com base no cep
function preencherCamposComCep(cep) {
    
    document.getElementById('bairro').value = '';
    document.getElementById('municipio').value = '';
    document.getElementById('estado').value = '';
    document.getElementById('endereco').value = '';

    // Chama a função de validação para cada campo preenchido
    validarCampoTexto(document.getElementById('bairro'), 3, 50);
    validarCampoTexto(document.getElementById('municipio'), 4, 50);
    validarCampoTexto(document.getElementById('estado'), 2, 2);
    validarCampoTexto(document.getElementById('endereco'), 5, 100);
}

// Adiciona ouvinte de evento de entrada para validar o cep
document.getElementById('cep').addEventListener('input', function() {
    if (validarCep(this.value)) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
        // Chama a função para preencher automaticamente os campos
        preencherCamposComCep(this.value);
    } else {
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');
    }
});

// Adiciona ouvintes de eventos de entrada para validar campos de texto
document.getElementById('bairro').addEventListener('input', function() {
    validarCampoTexto(this, 3, 50);
});

document.getElementById('municipio').addEventListener('input', function() {
    validarCampoTexto(this, 4, 50);
});

document.getElementById('estado').addEventListener('input', function() {
    validarCampoTexto(this, 2, 2);
});

document.getElementById('endereco').addEventListener('input', function() {
    validarCampoTexto(this, 5, 100);
});

// Adicione um listener de evento de input ao campo de número
document.getElementById('numero').addEventListener('input', function(event) {
    let numero = this.value.trim(); // Remove espaços em branco

    // Verifica se o número é válido (não está vazio)
    if (numero.length > 0) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');
    }
});


