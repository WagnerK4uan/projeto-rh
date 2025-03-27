<template>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-gradient-primary text-white">
                <h1 class="card-title text-center">Editar Colaborador</h1>
            </div>
            <div class="card-body">
                <div v-if="successMessage" class="alert alert-success">
                    {{ successMessage }}
                </div>
                <form @submit.prevent="updateEmployee">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="fullName" class="form-label">Nome Completo:</label>
                            <input type="text" id="fullName" class="form-control" v-model="employee.full_name"
                                placeholder="Digite o nome completo" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nickname" class="form-label">Apelido:</label>
                            <input type="text" id="nickname" class="form-control" v-model="employee.nickname"
                                placeholder="Digite o apelido">
                        </div>
                        <div class="col-md-6">
                            <label for="parentName" class="form-label">Nome do Pai/Mãe:</label>
                            <input type="text" id="parentName" class="form-control" v-model="employee.parent_name"
                                placeholder="Digite o nome do pai/mãe" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cpf" class="form-label">CPF:</label>
                            <input type="text" id="cpf" class="form-control" v-model="employee.cpf"
                                placeholder="000.000.000-00" required>
                        </div>
                        <div class="col-md-6">
                            <label for="birthDate" class="form-label">Data de Nascimento:</label>
                            <input type="date" id="birthDate" class="form-control" v-model="employee.birth_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="position" class="form-label">Cargo:</label>
                            <input type="text" id="position" class="form-control" v-model="employee.position"
                                placeholder="Digite o cargo" required>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-4">Atualizar Colaborador</button>
                    </div>
                </form>
                <div class="mt-4 d-flex justify-content-start">
                    <router-link :to="{ name: 'Index' }" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Voltar para a Lista de Colaboradores
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
import { onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
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
        const route = useRoute();
        const router = useRouter();
        const successMessage = ref('');

        // Obtém os dados do colaborador para edição
        const getEmployee = async () => {
            try {
                // Ajuste aqui para usar o endpoint correto (sem /edit)
                const uri = `http://127.0.0.1:8000/employees/${route.params.id}`;
                const response = await axios.get(uri);
                // Atribui os dados retornados à variável 'employee'
                Object.assign(employee, response.data);
            } catch (error) {
                console.error("Erro ao buscar colaborador:", error);
            }
        };

        // Atualiza os dados do colaborador
        const updateEmployee = async () => {
            try {
                const uri = `http://127.0.0.1:8000/employees/${route.params.id}`;
                await axios.patch(uri, employee); // Atualiza os dados com PATCH
                successMessage.value = 'Colaborador atualizado com sucesso!';
                setTimeout(() => {
                    successMessage.value = '';
                    router.push({ name: 'Index' }); // Redireciona para a lista de colaboradores
                }, 1000);
            } catch (error) {
                console.error("Erro ao atualizar colaborador:", error);
            }
        };

        onMounted(getEmployee); // Carrega os dados do colaborador assim que o componente for montado

        return {
            employee,
            updateEmployee,
            successMessage
        };
    }
}
</script>
