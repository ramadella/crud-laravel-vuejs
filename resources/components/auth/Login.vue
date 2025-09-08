<template>
    <!-- Login.vue -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-gradient-primary text-white">
                        <h1 class="card-title text-center">Login</h1>
                    </div>
                    <div class="card-body">
                        <div v-if="errorMessage" class="alert alert-danger">
                            {{ errorMessage }}
                        </div>
                        <form @submit.prevent="handleLogin">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" v-model="credentials.email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" v-model="credentials.password" required>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" v-model="credentials.role" required>
                                    <option value="staff">Staff</option>
                                    <option value="leader">Leader</option>
                                </select>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                        <div class="mt-3 text-center">
                            <span>Don't have an account?</span>
                            <router-link :to="{name:'Register'}">Register here</router-link>
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
        const credentials = reactive({email: '', password: '', role: 'staff'});
        const errorMessage = ref('');
        const router = useRouter();

        const handleLogin = async() => {
            try{
                const response = await axios.post('http://127.0.0.1:8000/api/login', credentials);
                const { access_token, user } = response.data;
                localStorage.setItem('token', access_token);
                localStorage.setItem('user', JSON.stringify(user));

                axios.defaults.headers.common['Authorization'] = `Bearer ${access_token}`;
                router.push({name: 'Index'});
            }
            catch(error){
                errorMessage.value = error.response?.data?.message || 'Login failed. Please check your credentials.';
                console.error('login failed', error);
            }
        };
        return { credentials, handleLogin, errorMessage};
    }
}

</script>