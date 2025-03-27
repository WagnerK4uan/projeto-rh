<template>
  <div class="container mt-5">
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 800px;">
      <div class="card-header bg-white border-bottom pb-3">
        <h2 class="mb-0 text-center">Editar Colaborador</h2>
      </div>
      <div class="card-body">

        <!-- Mensagens de Sucesso e Erro -->

        <div v-if="successMessage" class="alert alert-success text-center">
          {{ successMessage }}
        </div>
        <div v-if="errorMessage" class="alert alert-danger text-center">
          {{ errorMessage }}
        </div>

        <form @submit.prevent="updateEmployee">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="fullName" class="form-label">Nome Completo:</label>
              <input
                type="text"
                id="fullName"
                class="form-control"
                v-model="employee.full_name"
                placeholder="Digite o nome completo"
                required
              />
            </div>
            <div class="col-md-6">
              <label for="nickname" class="form-label">Apelido:</label>
              <input
                type="text"
                id="nickname"
                class="form-control"
                v-model="employee.nickname"
                placeholder="Digite o apelido"
              />
            </div>
            <div class="col-md-6">
              <label for="parentName" class="form-label">Nome do Pai/Mãe:</label>
              <input
                type="text"
                id="parentName"
                class="form-control"
                v-model="employee.parent_name"
                placeholder="Digite o nome do pai/mãe"
                required
              />
            </div>
            <div class="col-md-6">
              <label for="cpf" class="form-label">CPF:</label>
              <input
                type="text"
                id="cpf"
                class="form-control"
                v-model="employee.cpf"
                placeholder="000.000.000-00"
                required
                @input="formatCPF"
              />
            </div>
            <div class="col-md-6">
              <label for="birthDate" class="form-label">Data de Nascimento:</label>
              <input
                type="date"
                id="birthDate"
                class="form-control"
                v-model="employee.birth_date"
                required
              />
            </div>
            <div class="col-md-6">
              <label for="position" class="form-label">Cargo:</label>
              <input
                type="text"
                id="position"
                class="form-control"
                v-model="employee.position"
                placeholder="Digite o cargo"
                required
              />
            </div>
          </div>
          <div class="text-center mt-4 d-flex justify-content-center">
            <button
              type="button"
              class="btn btn-secondary px-4 mx-2"
              @click="clearForm"
            >
              Limpar
            </button>
            <button type="submit" class="btn btn-primary px-4">
              Atualizar Colaborador
            </button>
          </div>
        </form>

        <div class="mt-4 text-center">
          <router-link :to="{ name: 'Index' }" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left-circle"></i> Voltar para Lista
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { onMounted, reactive, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import axios from "axios";

export default {
  setup() {
    const employee = reactive({
      full_name: "",
      nickname: "",
      parent_name: "",
      cpf: "",
      birth_date: "",
      position: ""
    });
    const route = useRoute();
    const router = useRouter();
    const successMessage = ref("");
    const errorMessage = ref("");

    // Função para normalizar CPF
    const normalizeCPF = (cpf) => {
      let digits = cpf.replace(/\D/g, ""); // Remove qualquer caractere não numérico
      if (digits.length === 11) {
        return digits.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4"); // Formata o CPF
      }
      return cpf; // Se o CPF não for válido, retorna sem formatação
    };

    // Função para formatar CPF enquanto o usuário digita
    const formatCPF = () => {
      employee.cpf = normalizeCPF(employee.cpf);
    };

    const validateFields = () => {
      if (!employee.full_name || !employee.parent_name || !employee.cpf || !employee.birth_date || !employee.position) {
        return "Todos os campos obrigatórios devem ser preenchidos.";
      }

      // Validação de CPF
      if (!/^\d{3}\.\d{3}\.\d{3}-\d{2}$/.test(employee.cpf)) {
        return "O CPF precisa estar no formato correto (000.000.000-00).";
      }

      return null;
    };

    const getEmployee = async () => {
      try {
        const uri = `http://127.0.0.1:8000/employees/${route.params.id}`;
        const response = await axios.get(uri);
        // Normaliza o CPF ao buscar os dados
        response.data.cpf = normalizeCPF(response.data.cpf);
        Object.assign(employee, response.data);
      } catch (error) {
        console.error("Erro ao buscar colaborador:", error);
      }
    };

    const updateEmployee = async () => {
      const validationError = validateFields(); // Chama a função de validação
      if (validationError) {
        errorMessage.value = validationError; // Exibe a mensagem de erro
        successMessage.value = ""; // Limpa a mensagem de sucesso
        return;
      }

      try {
        // Normaliza o CPF antes de enviar a atualização
        employee.cpf = normalizeCPF(employee.cpf);
        const uri = `http://127.0.0.1:8000/employees/${route.params.id}`;
        await axios.patch(uri, employee);
        successMessage.value = "Colaborador atualizado com sucesso!";
        errorMessage.value = ""; // Limpa a mensagem de erro
        setTimeout(() => {
          successMessage.value = "";
          router.push({ name: "Index" });
        }, 1000);
      } catch (error) {
        errorMessage.value = "Erro ao atualizar colaborador. Tente novamente."; // Mensagem de erro
        successMessage.value = ""; // Limpa a mensagem de sucesso
        console.error("Erro ao atualizar colaborador:", error);
      }
    };

    const clearForm = () => {
      employee.full_name = "";
      employee.nickname = "";
      employee.parent_name = "";
      employee.cpf = "";
      employee.birth_date = "";
      employee.position = "";
    };

    onMounted(getEmployee);

    return {
      employee,
      clearForm,
      updateEmployee,
      successMessage,
      errorMessage,
      formatCPF
    };
  }
};
</script>

<style scoped>
.card {
  border-radius: 8px;
}
.card-header h2 {
  font-size: 1.75rem;
  font-weight: 500;
}
.form-control {
  border-radius: 4px;
}
.btn-primary {
  border-radius: 4px;
}
</style>
