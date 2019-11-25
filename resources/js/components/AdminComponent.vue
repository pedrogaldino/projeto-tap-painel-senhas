<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4" v-for="fila in filas">
                <div class="card">
                    <div class="card-header">{{ fila.nome }}</div>

                    <div class="card-body">
                        <ul>
                            <li v-for="(senha, key) in fila.senhas_ordenadas">
                                {{ senha.valor }}

                                <button v-if="key === 0" @click="chamar(senha.id)">Chamar</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                filas: []
            };
        },
        mounted() {
            this.loadFilas();

            Echo.channel('filas')
                .listen('NovaSenhaGeradaEvent', (e) => {
                    this.loadFilas();
                });
        },

        methods: {
            loadFilas() {
                axios
                    .get('api/admin/filas')
                    .then((res) => {
                        this.filas = res.data.data;
                    })
            },

            chamar(senha) {
                axios
                    .put('api/admin/filas/' + senha + '/chamar')
                    .then((res) => {
                        this.loadFilas();
                    })
            }
        }
    }
</script>
