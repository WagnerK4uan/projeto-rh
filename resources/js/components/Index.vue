<template>
    <div class="container mt-5">
        <!-- Cabeçalho -->
        <div
            class="d-flex justify-content-between align-items-center mb-4 p-4 border rounded shadow-sm"
        >
            <h2 class="fw-bold">Colaboradores da Bruning</h2>
            <router-link to="/create" class="btn btn-primary">
                <font-awesome-icon :icon="['fas', 'user-plus']" class="me-1" />
                Cadastrar
            </router-link>
        </div>

        <!-- Mensagem de sucesso -->
        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>

        <!-- Lista de colaboradores -->
        <div class="border p-4 rounded shadow-sm">
            <h3 class="fw-bold mb-4">Lista de Colaboradores</h3>

            <div v-if="employees.length === 0" class="alert alert">
                Nenhum colaborador encontrado.
            </div>

            <div
                v-for="employee in employees"
                :key="employee.id"
                class="card shadow-sm mb-3"
            >
                <div
                    class="card-body d-flex justify-content-between align-items-center"
                >
                    <div>
                        <strong
                            >{{ employee.id }} -
                            {{ employee.full_name }}</strong
                        >
                        <div>
                            Nascimento:
                            <strong>{{
                                formatDate(employee.birth_date)
                            }}</strong>
                        </div>
                    </div>
                    <div>
                        <router-link
                            :to="{ name: 'Show', params: { id: employee.id } }"
                            class="btn btn-outline-primary btn-sm me-2"
                        >
                            <font-awesome-icon :icon="['fas', 'search']" />
                        </router-link>
                        <router-link
                            :to="{ name: 'Edit', params: { id: employee.id } }"
                            class="btn btn-outline-primary btn-sm me-2"
                        >
                            <font-awesome-icon :icon="['fas', 'pencil-alt']" />
                        </router-link>
                        <button
                            class="btn btn-outline-danger btn-sm"
                            @click="openDeleteConfirmation(employee.id)"
                        >
                            <font-awesome-icon :icon="['fas', 'trash-alt']" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de confirmação -->
        <div
            class="modal fade"
            id="deleteConfirmationModal"
            tabindex="-1"
            aria-labelledby="deleteConfirmationModalLabel"
            aria-hidden="true"
            ref="deleteModal"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            class="modal-title"
                            id="deleteConfirmationModalLabel"
                        >
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
                            class="btn btn-secondary btn-sm"
                            @click="closeModal"
                        >
                            Cancelar
                        </button>
                        <button
                            type="button"
                            class="btn btn-danger btn-sm"
                            @click="confirmDelete"
                        >
                            Excluir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { onMounted, ref } from "vue";
import axios from "axios";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faList,
    faUserPlus,
    faPencilAlt,
    faTrashAlt,
    faSearch,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faList, faUserPlus, faPencilAlt, faTrashAlt, faSearch);

export default {
    components: { FontAwesomeIcon },
    setup() {
        const employees = ref([]);
        const employeeIdToDelete = ref(null);
        const deleteModal = ref(null);
        const successMessage = ref("");

        const fetchEmployees = async () => {
            try {
                const response = await axios.get(
                    "http://127.0.0.1:8000/employees"
                );
                employees.value = response.data;
            } catch (error) {
                console.error("Erro ao buscar colaboradores:", error);
            }
        };

        const formatDate = (dateStr) => {
            const date = new Date(dateStr);
            return date.toLocaleDateString("pt-BR");
        };

        const openDeleteConfirmation = (id) => {
            employeeIdToDelete.value = id;
            const modal = new bootstrap.Modal(deleteModal.value);
            modal.show();
        };

        const closeModal = () => {
            const modal = bootstrap.Modal.getInstance(deleteModal.value);
            modal.hide();
        };

        const confirmDelete = async () => {
            try {
                await axios.delete(
                    `http://127.0.0.1:8000/employees/${employeeIdToDelete.value}`
                );
                successMessage.value = "Colaborador excluído com sucesso!";
                fetchEmployees();
                closeModal();

                // Limpar a mensagem de sucesso após 3 segundos
                setTimeout(() => {
                    successMessage.value = "";
                }, 2200); // 3 segundos
            } catch (error) {
                console.error("Erro ao excluir colaborador:", error);
            }
        };

        onMounted(fetchEmployees);

        return {
            employees,
            formatDate,
            openDeleteConfirmation,
            closeModal,
            confirmDelete,
            deleteModal,
            successMessage,
        };
    },
};
</script>
