<!-- Index.vue -->
<template>
    <div class="container mt-5">
        <h1 class="mb-4">EMPLOYEES DATA</h1>
        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>
        <div class="d-flex justify-content-end mb-4">
            <router-link v-if="userRole === 'leader'" :to="{name: 'Create'}" class="btn btn-success"><i class="bi bi-plus-lg"></i> Create New Employee Data</router-link>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-warning">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Position</th>
                        <th scope="col">department</th>
                        <th scope="col">task</th>
                        <th scope="col">salary</th>
                        <th v-if="userRole === 'leader'" scope="col" style="width: 20%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(employee, index) in employees" v-bind:key="employee.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ employee.name }}</td>
                        <td>{{ employee.posisi }}</td>
                        <td>{{ employee.department }}</td>
                        <td>{{ employee.tugas }}</td>
                        <td>{{ employee.gaji }}</td>
                        <td v-if="userRole === 'leader'">
                            <div>
                                <router-link :to="{name: 'Edit', params: {id: employee.id}}" class="btn btn-sm btn-outline-primary me-2"><i class="bi bi-pencil-square me-1"></i> Edit</router-link>
                                <button class="btn btn-sm btn-outline-danger" @click="openDeleteConfirmation(employee.id)"><i class="bi bi-trash me-1"></i> Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- delete confirmation -->
     <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true" ref="deleteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    are you sure want to delete this data?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModal">Cancel</button>
                    <button type="button" class="btn btn-danger" @click="confirmDelete">Delete</button>
                </div>
            </div>
        </div>    
     </div>
</template>
<script>
import axios from 'axios';
import { useRouter } from 'vue-router';
import { ref, onMounted, computed } from 'vue';

export default{
    setup(){
        const employees =ref([]);
        const employeeIdToDelete = ref(null);
        const deleteModal = ref(null);
        const successMessage = ref('');
        const router = useRouter();
        const user = ref(null);
        const userRole = computed(() => {
            return user.value ? user.value.role : null;
        })

        onMounted(() => {
            const storedUser = localStorage.getItem('user');
            if(storedUser){
                user.value = JSON.parse(storedUser);
            }
            fetchemployees();
        })

        const fetchemployees = async () => {
            try{
                const uri = 'http://127.0.0.1:8000/api/employees';
                const response = await axios.get(uri);
                employees.value = response.data.data;
            }
            catch(error){
                console.error('error fetching data:', error);
                if(error.response.status === 401){
                    router.push({name: 'Login'});
                }
            }
        };

        const deleteEmployee = async(id) => {
            try{
                const uri = `http://127.0.0.1:8000/api/employees/${id}`;
                await axios.delete(uri);
                employees.value = employees.value.filter((emp) => emp.id !== id);
                successMessage.value = 'employees data deleted successfully';
                setTimeout(() => {
                    successMessage.value = '';
                }, 1000);
            }
            catch(error){
                console.error('error deleting employee data:', error);
            }
        }
        const confirmDelete = async() => {
            if(employeeIdToDelete.value !== null){
                await deleteEmployee(employeeIdToDelete.value);
                closeModal();
            }
        };
        const openDeleteConfirmation = (id) => {
            employeeIdToDelete.value = id;
            if(deleteModal.value){
                const modelInstance = new window.bootstrap.Modal(deleteModal.value);
                modelInstance.show();
            }
        };

        const closeModal = () => {
            const modalInstance = window.bootstrap.Modal.getInstance(deleteModal.value);
            if(modalInstance){
                modalInstance.hide();
            }
        };
        return{
            employees,
            userRole,
            openDeleteConfirmation,
            confirmDelete,
            deleteEmployee,
            deleteModal,
            closeModal,
            successMessage
        };
    }
}
</script>