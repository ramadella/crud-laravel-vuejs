<!-- Edit.vue -->
<template>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-gradient-primary text-white">
                <h1 class="card-title text-center">Edit an Employee</h1>
            </div>
            <div class="card-body">
                <div v-if="successMessage" class="alert alert-success">
                    {{ successMessage }}
                </div>
                <form @submit.prevent="updateEmployee">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="employeeName" class="form-label">Name</label>
                            <input type="text" id="employeeName" class="form-control" v-model="employees.name" placeholder="name" required>                
                        </div>
                        <div class="col-md-6">
                            <label for="employeePosition" class="form-label">Position</label>
                            <input type="text" id="employeePosition" class="form-control" v-model="employees.posisi" placeholder="posisi" required>                
                        </div>
                        <div class="col-md-6">
                            <label for="employeeDepartment" class="form-label">Department</label>
                            <input type="text" id="employeeDepartment" class="form-control" v-model="employees.department" placeholder="department" required>                
                        </div>
                        <div class="col-md-6">
                            <label for="employeeTask" class="form-label">Task</label>
                            <input type="text" id="employeeTask" class="form-control" v-model="employees.tugas" placeholder="task" required>                
                        </div>
                        <div class="col-md-6">
                            <label for="employeeSalary" class="form-label">Salary</label>
                            <input type="text" id="employeeSalary" class="form-control" v-model="employees.gaji" placeholder="salary" required>                
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-4">Update Employee</button>
                    </div>
                </form>
                <div class="mt-4 flex justify-content-start">
                    <router-link :to="{name: 'Index'}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Return to Employees List
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.bg-gradient-primary{
    background: linear-gradient(45deg, #007bff, #6610f2);
}
</style>
<script>
import axios from 'axios';
import { onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export default{
    setup(){
        let employees = reactive({name: '', posisi: '', department: '', tugas: '', gaji: ''});
        const route = useRoute();
        const router = useRouter();
        const successMessage = ref('');

        const getEmployee = async() => {
            try{
                const uri = `http://127.0.0.1:8000/api/employees/${route.params.id}`;
                const response = await axios.get(uri);
                Object.assign(employees, response.data.data);
                employees.gaji = Number(employees.gaji);
            }
            catch(error){
                console.error('failed to fetch employee data', error);
            }
        };

        const updateEmployee = async() => {
            try{
                const uri = `http://127.0.0.1:8000/api/employees/${route.params.id}`;
                const res = await axios.put(uri, employees);
                successMessage.value = 'employee updated successfully';
                router.push({name: 'Index', query:{refresh: Date.now()}});
            }
            catch(error){
                console.error('update failed', error);
            }
        };
        
        onMounted(getEmployee);
        return{
            employees,
            updateEmployee,
            successMessage
        }
    }
}
</script>