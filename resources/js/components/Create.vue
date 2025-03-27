<template>
  <div class="container mt-5">
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 800px;">
      <div class="card-header bg-white border-bottom pb-3">
        <h2 class="mb-0 text-center">Cadastrar Colaborador</h2>
      </div>
      <div class="card-body">
        <!-- Mensagens de Sucesso e Erro -->
        <div v-if="successMessage" class="alert alert-success text-center">
          {{ successMessage }}
        </div>
        <div v-if="errorMessage" class="alert alert-danger text-center">
          {{ errorMessage }}
        </div>
        
        <!-- Formulário de Cadastro -->
        <form @submit.prevent="addEmployee">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="fullName" class="form-label">Nome Completo:</label>
              <input
                type="text"
                class="form-control"
                id="fullName"
                v-model="employee.full_name"
                placeholder="Digite o nome completo"
                required
              />
            </div>
            <div class="col-md-6">
              <label for="nickname" class="form-label">Apelido:</label>
              <input
                type="text"
                class="form-control"
                id="nickname"
                v-model="employee.nickname"
                placeholder="Digite o apelido"
              />
            </div>
            <div class="col-md-6">
              <label for="parentName" class="form-label">Nome do Pai/Mãe:</label>
              <input
                type="text"
                class="form-control"
                id="parentName"
                v-model="employee.parent_name"
                placeholder="Digite o nome do pai/mãe"
                required
              />
            </div>
            <div class="col-md-6">
              <label for="cpf" class="form-label">CPF:</label>
              <input
                type="text"
                class="form-control"
                id="cpf"
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
                class="form-control"
                id="birthDate"
                v-model="employee.birth_date"
                required
              />
            </div>
            <div class="col-md-6">
              <label for="position" class="form-label">Cargo:</label>
              <input
                type="text"
                class="form-control"
                id="position"
                v-model="employee.position"
                placeholder="Digite o cargo"
                required
              />
            </div>
          </div>

          <!-- Botões -->
          <div class="text-center mt-4 d-flex justify-content-center">
            <button
              type="button"
              class="btn btn-secondary px-4 mx-2"
              @click="clearForm"
            >
              Limpar
            </button>
            <button type="submit" class="btn btn-primary px-4">
              <i class="bi bi-plus-lg"></i> Cadastrar
            </button>
          </div>
        </form>

        <!-- Link para Voltar -->
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
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
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

    const router = useRouter();
    const successMessage = ref("");
    const errorMessage = ref("");

    // Função para normalizar CPF
    const normalizeCPF = (cpf) => {
      let digits = cpf.replace(/\D/g, ""); // Remove qualquer caractere não numérico
      if (digits.length === 11) {
        return digits.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4"); // Formata o CPF
      }
      return cpf;
    };

    // Função para formatar CPF enquanto o usuário digita
    const formatCPF = () => {
      employee.cpf = normalizeCPF(employee.cpf);
    };

    // Função para validar os campos antes de submeter
  // Função para validar os campos antes de submeter
const validateFields = () => {
  if (!employee.full_name || !employee.parent_name || !employee.cpf || !employee.birth_date || !employee.position) {
    return "Todos os campos obrigatórios devem ser preenchidos.";
  }

  // Validação de CPF
  if (!/^\d{3}\.\d{3}\.\d{3}-\d{2}$/.test(employee.cpf)) {
    return "O CPF precisa estar no formato correto (000.000.000-00).";
  }

  // Validação da data de nascimento
  const birthDate = new Date(employee.birth_date);
  if (isNaN(birthDate.getTime())) {
    return "A data de nascimento deve ser válida.";
  }

  return null;
};

    const addEmployee = async () => {
      const validationError = validateFields();
      if (validationError) {
        errorMessage.value = validationError;
        successMessage.value = "";
        return;
      }

      errorMessage.value = "";
      // Normalizando o CPF antes de enviar ao backend
      employee.cpf = normalizeCPF(employee.cpf);
      const uri = "http://127.0.0.1:8000/employees";
      try {
        await axios.post(uri, employee);
        successMessage.value = "Colaborador cadastrado com sucesso!";
        setTimeout(() => {
          successMessage.value = "";
          router.push({ name: "Index" });
        }, 1000);
      } catch (error) {
        console.error("Erro ao cadastrar colaborador:", error);
        errorMessage.value = "Erro ao cadastrar colaborador. Tente novamente.";
        successMessage.value = "";
      }
    };

    const clearForm = () => {
      employee.full_name = "";
      employee.nickname = "";
      employee.parent_name = "";
      employee.cpf = "";
      employee.birth_date = "";
      employee.position = "";
      errorMessage.value = "";
      successMessage.value = "";
    };

    return {
      employee,
      clearForm,
      addEmployee,
      successMessage,
      errorMessage,
      formatCPF // Adicionando formatCPF para ser usado no template
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
