<template>
    <div class="container">
        <div class="row justify-content-center" v-if="!senhaGerada">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Gerar nova senha</div>

                    <div class="card-body">
                        <ul>
                            <li v-for="fila in filas">
                                <button @click="gerarSenha(fila.id, false)">{{ fila.nome }}</button>
                                <button @click="gerarSenha(fila.id, true)" class="btn-danger">Preferencial</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center" v-if="senhaGerada">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Senha gerada!</div>

                    <div class="card-body">
                        {{ senhaGerada.valor }}

                        <hr>

                        <div>
                            Acompanhe lendo o QRCode! <br>

                            <canvas id="canvas"></canvas>

                            <br>

                            Ou acessando: <br>
                            <a :href="urlForNotifications" target="_blank">{{ urlForNotifications }}</a>
                        </div>

                        <hr>

                        <button @click="reset()">Voltar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import * as QRCode from 'qrcode';

    export default {
        props: {
            baseUrl: {
                type: String
            }
        },

        data(){
            return {
                senhaGerada: null,
                filas: [],
                urlForNotifications: null
            }
        },

        mounted() {
            this.loadFilas();
        },

        methods: {
            gerarSenha(fila, preferencial = false){
                axios
                    .post('api/filas/' + fila + '/senhas', {
                        preferencial: preferencial
                    })
                    .then((res) => {
                        this.senhaGerada = res.data.data;

                        this.urlForNotifications = this.baseUrl + '/app?senha=' + this.senhaGerada.valor;

                        setTimeout(() => {
                            this.generateQRCode(this.urlForNotifications);
                        }, 1000);
                    })
            },

            generateQRCode(url){
                QRCode.toCanvas(document.getElementById('canvas'), url, function (error) {
                    if (error) console.error(error);
                    console.log('success!');
                })
            },

            loadFilas(){
                axios
                    .get('api/filas')
                    .then((res) => {
                        this.filas = res.data.data;
                    })
            },

            reset() {
                this.senhaGerada = null;
            }
        }
    }
</script>
