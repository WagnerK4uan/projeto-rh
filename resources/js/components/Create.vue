<template>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-gradient-primary text-white">
                <h1 class="card-title">Cadastrar Colaborador</h1>
            </div>
            <div class="card-body">
                <div v-if="successMessage" class="alert alert-success">
                    {{ successMessage }}
                </div>
                <form @submit.prevent="addEmployee">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="fullName" class="form-label">Nome Completo:</label>
                            <input type="text" class="form-control" id="fullName" v-model="employee.full_name"
                                placeholder="Digite o nome completo" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nickname" class="form-label">Apelido:</label>
                            <input type="text" class="form-control" id="nickname" v-model="employee.nickname"
                                placeholder="Digite o apelido">
                        </div>
                        <div class="col-md-6">
                            <label for="parentName" class="form-label">Nome do Pai/Mãe:</label>
                            <input type="text" class="form-control" id="parentName" v-model="employee.parent_name"
                                placeholder="Digite o nome do pai/mãe" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cpf" class="form-label">CPF:</label>
                            <input type="text" class="form-control" id="cpf" v-model="employee.cpf"
                                placeholder="000.000.000-00" required>
                        </div>
                        <div class="col-md-6">
                            <label for="birthDate" class="form-label">Data de Nascimento:</label>
                            <input type="date" class="form-control" id="birthDate" v-model="employee.birth_date"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="position" class="form-label">Cargo:</label>
                            <input type="text" class="form-control" id="position" v-model="employee.position"
                                placeholder="Digite o cargo" required>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-plus-lg"></i> Cadastrar
                        </button>
                    </div>
                </form>
                <div class="mt-4 d-flex justify-content-start">
                    <router-link :to="{ name: 'Index' }" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Voltar para Lista de Colaboradores
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #6610f2);
}
</style>

<script>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
    setup() {
        const employee = reactive({
            full_name: '',
            nickname: '',
            parent_name: '',
            cpf: '',
            birth_date: '',
            position: ''
        });

        const router = useRouter();
        const successMessage = ref('');

        // Função para normalizar o CPF
        const normalizeCPF = (cpf) => {
            // Remove todos os caracteres não numéricos
            let digits = cpf.replace(/\D/g, '');
            // Se tiver 11 dígitos, formata como 000.000.000-00
            if (digits.length === 11) {
                return digits.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            }
            return cpf; // Caso contrário, retorna o CPF original
        };

        const addEmployee = async () => {
            // Normaliza o CPF antes de enviar a requisição
            employee.cpf = normalizeCPF(employee.cpf);
            
            const uri = 'http://127.0.0.1:8000/employees';
            try {
                await axios.post(uri, employee);
                successMessage.value = 'Colaborador cadastrado com sucesso!';
                setTimeout(() => {
                    successMessage.value = '';
                    router.push({ name: 'Index' }); // Redireciona para a lista
                }, 1000);
            } catch (error) {
                console.error('Erro ao cadastrar colaborador:', error);
            }
        };

        return {
            employee,
            addEmployee,
            successMessage
        };
    }
}
</script>
