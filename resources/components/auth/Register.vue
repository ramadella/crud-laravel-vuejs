<template>
    <!-- Register.vue -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-gradient-primary text-white">
                        <h1 class="card-title text-center">Register</h1>
                    </div>
                    <div class="card-body">
                        <div v-if="errorMessage" class="alert alert-danger">
                            <ul class="mb-0">
                                <li v-for="(error, index) in errorMessages" v-bind:key="index">{{ error[0] }}</li>
                            </ul>
                        </div>
                        <form @submit.prevent="handleRegister">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" v-model="user.name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" v-model="user.email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" v-model="user.password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Passsword</label>
                                <input type="password" class="form-control" id="password_confirmation" v-model="user.password_confirmation" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                        <div class="mt-3 text-center">
                            <span>Already have an account?</span>
                            <router-link :to="{name: 'Login'}">Login here</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

export default{
    setup(){
        const user = reactive({name: '', email: '', password: '', password_confirmation: ''});
        const errorMessage = ref('');
        const errorMessages = ref({});
        const router = useRouter();

        const handleRegister = async() => {
            try{
                await axios.post('http://127.0.0.1:8000/api/register', user);
                router.push({name: 'Login'});
            }
            catch(error){
                errorMessage.value = true;
                if(error.response.status === 422){
                    errorMessages.value = error.response.data.errors;
                }
                console.error('Register failed', error);
            }
        };

        return {
            user, handleRegister, errorMessage, errorMessages
        };
    }
}
</script>