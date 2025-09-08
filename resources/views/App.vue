<!-- app.vue -->
<template>
    <div>
        <nav class="ps-3 navbar navbar-expand-lg navbar-dark bg-warning">
            <div class="container">
                <router-link class="navbar-brand" to="/">
                    <img src="../../public//tugu.png" alt="Logo" height="40" />
                </router-link>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item" v-if="isLoggedIn">
                            <button class="btn btn-danger" @click="logout">Logout</button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container my-4">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
import { ref, watch, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
export default{
    setup(){
        const isLoggedIn = ref(false);
        const router = useRouter();
        const route = useRoute();

        const checkLoginStatus = () => {
            isLoggedIn.value = !!localStorage.getItem('token');
        };
        
        const logout = async() => {
            try{
                await axios.post('http://127.0.0.1:8000/api/logout');
            }
            catch(error){
                console.error('logout failed on server', error);
            }
            finally{
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                delete axios.defaults.headers.common['Authorization'];
                isLoggedIn.value = false;
                router.push({name: 'Login'});
            }
        };

        onMounted(checkLoginStatus);
        watch(() => route.path, checkLoginStatus);

        return{
            isLoggedIn, logout
        }
    }
}
</script>