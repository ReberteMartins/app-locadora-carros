<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">


                <!-- Inicio do card de busca -->
                <card-component titulo="Buscar de Marcas">

                        <template v-slot:conteudo>
                            <div class="row">
                                <div class="col mb-3">
                                    <input-container-component titulo="ID" id="inputId" id-help="IdHelp" texto-ajuda="Informe o ID da marca">
                                        <input type="number" class="form-control" id="InputId" aria-describedby="idHelp" placeholder="ID">
                                    </input-container-component>
                                </div>

                                <div class="col mb-3">
                                    <input-container-component titulo="Nome da marca" id="InputNome" id-help="nomeHelp" texto-ajuda="Informe o nome do registro">
                                        <input type="text" class="form-control" id="InputNome" aria-describedby="nomeHelp" placeholder="Nome da Marca">
                                    </input-container-component>

                                </div>
                            </div>
                        </template>

                        <template v-slot:rodape>
                            <button type="submit" class="btn btn-primary btn-sm float-end">Pesquisar</button>
                        </template>

                </card-component>
                <!-- Fim do card de busca -->



                <!-- Inicio do card de listagem de marcas -->
                <card-component titulo="Relação de Marcas">

                        <template v-slot:conteudo>
                            <table-component></table-component>
                        </template>

                        <template v-slot:rodape>
                            <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalMarca">Adicionar</button>
                        </template>

                </card-component>

                <!-- Fim do card de listagem de marcas -->

            </div>
        </div>
        <!-- Button trigger modal -->

        <!-- Modal -->
        <modal-component id="modalMarca" titulo="Adicionar Marca">
            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome da marca" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome do registro">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome da Marca" v-model="nomeMarca">
                    </input-container-component>
                    {{ nomeMarca}}
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Slecione uma imagem no formato PNG">
                        <input type="file" class="form-control" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                    {{arquivoImagem}}
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>

            </template>
        </modal-component>
    </div>
</template>

<script>
    export default {
        computed: {
                token(){
                    let token = localStorage.getItem('token')

                    return `Bearer ${token}`
                }
            },
        data() {
            return {
                urlBase: 'http://localhost:8000/api/marca',
                nomeMarca: '',
                arquivoImagem: [],
            }
        },
        methods:{
            carregarImagem(e){
                this.arquivoImagem = e.target.files
            },
            salvar(){
                console.log(this.nomeMarca, this.arquivoImagem[0])

                let formData = new FormData();
                formData.append('nome', this.nomeMarca)
                formData.append('imagem', this.arquivoImagem[0])

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                // URL | Conteudo | Configuração
                axios.post( this.urlBase, formData, config).then(response=> {
                    console.log(response)
                })
                .catch(errors => {
                    console.log(errors)
                })
            }
        }
    }
</script>
