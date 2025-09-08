<!-- Create.vue -->
<template>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-gradient-primary text-white">
                <h1 class="card-title">ADD AN EMPLOYEE</h1>
            </div>
            <div class="card-body">
                <div v-if="successMessage" class="alert alert-success">
                    {{ successMessage }}
                </div>
                <form @submit.prevent="addEmployee">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="employeeName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="employeeName" v-model="employees.name" placeholder="Enter your name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="employeePosition" class="form-label">Position</label>
                            <input type="text" class="form-control" id="employeePosition" v-model="employees.posisi">
                        </div>
                        <div class="col-md-6">
                            <label for="employeeDepartment" class="form-label">Department</label>
                            <input type="text" class="form-control" id="employeeDepartment" v-model="employees.department" placeholder="department" required>
                        </div>
                        <div class="col-md-6">
                            <label for="employeeTask" class="form-label">Task</label>
                            <input type="text" class="form-control" id="employeeTask" v-model="employees.tugas"placeholder="task" required>
                        </div>
                        <div class="col-md-6">
                            <label for="employeeSalary" class="form-label">Salary</label>
                            <input type="text" class="form-control" id="employeeSalary" v-model="employees.gaji" placeholder="salary" required>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-plus-lg"></i>Add Employee</button>
                    </div>
                </form>
                <div class="mt-4 d-flex justify-content-start">
                    <router-link :to="{ name: 'Index'}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Return to Employees List
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';


export default {
    setup() {
        let employees = reactive({ name: '', posisi: '', department: '', tugas: '', gaji: '' });
        const router = useRouter();
        const successMessage = ref('');
        const addEmployee = async () => {
            const uri = 'http://127.0.0.1:8000/api/employees';
            try {
                await axios.post(uri, employees);
                successMessage.value = 'employee added successfully';
                router.push({ name: 'Index'});
            }
            catch (error) {
                console.error('error adding employee data:', error)
            }
        };
        return {
            employees,
            addEmployee,
            successMessage
        };
    }
}

</script>