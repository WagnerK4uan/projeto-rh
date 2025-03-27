<template>
    <div class="container mt-5">
        <h1 class="mb-4">Colaboradores</h1>
        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>
        <div class="d-flex justify-content-end mb-4">
            <router-link :to="{ name: 'Create' }" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> Cadastrar Novo Colaborador
            </router-link>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Nome Completo</th>
                        <th scope="col">Apelido</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Cargo</th>
                        <th scope="col" style="width: 20%">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="employee in employees" :key="employee.id">
    <td>{{ employee.id }}</td>
    <td>{{ employee.full_name }}</td>
    <td>{{ employee.nickname }}</td> <!-- Aqui corrigimos para exibir o apelido -->
    <td>{{ employee.cpf }}</td>
    <td>{{ employee.position }}</td>
    <td>
        <router-link
            :to="{
                name: 'Edit',
                params: { id: employee.id },
            }"
            class="btn btn-sm btn-outline-primary me-2"
        >
            <i class="bi bi-pencil-square me-1"></i> Editar
        </router-link>
        <button
            class="btn btn-sm btn-outline-danger"
            @click="openDeleteConfirmation(employee.id)"
        >
            <i class="bi bi-trash me-1"></i> Excluir
        </button>
    </td>
</tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div
        class="modal fade"
        id="deleteConfirmationModal"
        tabindex="-1"
        aria-labelledby="deleteConfirmationModalLabel"
        aria-hidden="true"
        ref="deleteModal"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">
                        Confirmar Exclusão
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        @click="closeModal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir este colaborador?
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        @click="closeModal"
                    >
                        Cancelar
                    </button>
                    <button
                        type="button"
                        class="btn btn-danger"
                        @click="confirmDelete"
                    >
                        Excluir
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { onMounted, ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

export default {
    setup() {
        const router = useRouter();
        const employees = ref([]);
        const employeeIdToDelete = ref(null);
        const deleteModal = ref(null);
        const successMessage = ref("");

        // Busca os colaboradores na API
        const fetchEmployees = async () => {
            try {
                const uri = "http://127.0.0.1:8000/employees";
                const response = await axios.get(uri);
                employees.value = response.data;
            } catch (error) {
                console.error("Erro ao buscar colaboradores:", error);
            }
        };

        // Abre o modal de confirmação de exclusão
        const openDeleteConfirmation = (id) => {
            employeeIdToDelete.value = id;
            const modalInstance = new bootstrap.Modal(deleteModal.value);
            modalInstance.show();
        };

        // Fecha o modal
        const closeModal = () => {
            const modalInstance = bootstrap.Modal.getInstance(
                deleteModal.value
            );
            if (modalInstance) {
                modalInstance.hide();
            }
        };

        // Confirma a exclusão e deleta o colaborador
        const confirmDelete = async () => {
            if (employeeIdToDelete.value !== null) {
                await deleteEmployee(employeeIdToDelete.value);
                closeModal();
            }
        };

        // Função para deletar o colaborador
        const deleteEmployee = async (id) => {
            try {
                const uri = `http://127.0.0.1:8000/employees/${id}`;
                await axios.delete(uri);
                employees.value = employees.value.filter(
                    (employee) => employee.id !== id
                );
                successMessage.value = "Colaborador excluído com sucesso!";
                // Limpa a mensagem após alguns segundos
                setTimeout(() => {
                    successMessage.value = "";
                }, 2000);
            } catch (error) {
                console.error("Erro ao excluir colaborador:", error);
            }
        };

        onMounted(fetchEmployees);

        return {
            employees,
            openDeleteConfirmation,
            confirmDelete,
            deleteEmployee,
            deleteModal,
            closeModal,
            successMessage,
        };
    },
};
</script>
