<template>
    <div class="container mt-5">
      <div class="card shadow-sm border-0 mx-auto" style="max-width: 800px;">
        <div class="card-header bg-white border-bottom pb-3">
          <h2 class="mb-0 text-center">Detalhes do Colaborador</h2>
        </div>
        <div class="card-body">
          <!-- Mensagens de Sucesso e Erro -->
          <div v-if="successMessage" class="alert alert-success text-center">
            {{ successMessage }}
          </div>
          <div v-if="errorMessage" class="alert alert-danger text-center">
            {{ errorMessage }}
          </div>
  
          <div v-if="employee" class="row">
            <div class="col-md-6">
              <h5>Nome Completo:</h5>
              <p>{{ employee.full_name }}</p>
            </div>
            <div class="col-md-6">
              <h5>Apelido:</h5>
              <p>{{ employee.nickname || 'Não informado' }}</p>
            </div>
            <div class="col-md-6">
              <h5>Nome do Pai/Mãe:</h5>
              <p>{{ employee.parent_name }}</p>
            </div>
            <div class="col-md-6">
              <h5>CPF:</h5>
              <p>{{ employee.cpf }}</p>
            </div>
            <div class="col-md-6">
              <h5>Data de Nascimento:</h5>
              <p>Nascimento: <strong>{{ formatDate(employee.birth_date) }}</strong></p>
            </div>
            <div class="col-md-6">
              <h5>Cargo:</h5>
              <p>{{ employee.position }}</p>
            </div>
          </div>
  
          <div class="mt-4 text-center">
            <router-link :to="{ name: 'Index' }" class="btn btn-outline-secondary btn-sm">
              <i class="bi bi-arrow-left-circle"></i> Voltar para Lista
            </router-link>
            <router-link :to="{ name: 'Edit', params: { id: employee.id } }" class="btn btn-primary btn-sm mx-2">
              <i class="bi bi-pencil"></i> Editar Colaborador
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
      const successMessage = ref("");
      const errorMessage = ref(""); // Mensagem de erro
      const route = useRoute();
  
      // Função para buscar o colaborador
      const getEmployee = async () => {
        try {
          const uri = `http://127.0.0.1:8000/employees/${route.params.id}`;
          const response = await axios.get(uri);
          Object.assign(employee, response.data);
        } catch (error) {
          errorMessage.value = "Erro ao carregar os dados do colaborador.";
          console.error("Erro ao buscar colaborador:", error);
        }
      };
  
      const formatDate = (dateStr) => {
    const date = new Date(dateStr);
    // Ajustar para o fuso horário local sem alterar o horário
    return new Date(date.getTime() + date.getTimezoneOffset() * 60000).toLocaleDateString("pt-BR");
};
      onMounted(getEmployee);
  
      return {
        employee,
        formatDate,
        successMessage,
        errorMessage
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
  .card-body h5 {
    font-weight: 600;
  }
  .card-body p {
    font-size: 1rem;
  }
  </style>
  