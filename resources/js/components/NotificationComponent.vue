<template>
    <div>
        <div v-if="senha">
            <div v-if="!ready">
                <h1>Ative as notificações para receber avisos sobre a senha {{ senha }}</h1>
                <button @click="requestPermission()">Receber Notificações</button>
            </div>

            <div v-if="ready">
                Você será notificado sobre a senha {{ senha }}
            </div>

        </div>

        <div v-if="!senha">
            <h1>Senha inválida</h1>
        </div>
    </div>
</template>

<style>

</style>

<script>
    import firebase from 'firebase';

    export default {
        props: {
            senha: {
                type: String
            }
        },

        data(){
            return {
                ready: false
            }
        },

        mounted() {
            console.log('ready');

            this.init();
        },

        methods : {

            init() {
                firebase.initializeApp({
                    apiKey: "AIzaSyBkn4eA--VA8LSwmEN_SmKAPGudkc-fqeQ",
                    authDomain: "projeto-tap-20a75.firebaseapp.com",
                    databaseURL: "https://projeto-tap-20a75.firebaseio.com",
                    projectId: "projeto-tap-20a75",
                    storageBucket: "projeto-tap-20a75.appspot.com",
                    messagingSenderId: "24376762653",
                    appId: "1:24376762653:web:2f4646b6f919e8f58e01f4"
                });

                navigator
                    .serviceWorker
                    .register('/js/firebase-messaging-sw.js')
                    .then((registration) => {
                        firebase.messaging().useServiceWorker(registration);
                    });
            },

            async requestPermission(){
                try {
                    const messaging = firebase.messaging();
                    await messaging.requestPermission();
                    const token = await messaging.getToken();

                    this.registerToken(token);

                    return token;
                } catch (error) {
                    console.error(error);
                }
            },

            registerToken(token){
                axios
                    .put('api/senhas/notifications', {
                        token: token,
                        senha: this.senha
                    })
                    .then((res) => {
                        this.ready = true;
                    })
                    .catch(() => {
                        alert('Ocorreu um erro, tente novamente!');
                    })
            }

        }

    }
</script>
