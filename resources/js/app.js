/**
 * --------------------------------------------------------------------------
 * Carrega dependências do projeto (Bootstrap, Axios, etc.)
 * --------------------------------------------------------------------------
 */
import './bootstrap';
import { createApp } from 'vue';

import { createStore } from 'vuex'

// Vue.use(Vuex)

const store = new createStore({
    state: {
        item: {},
        transacao: {status: '', mensagem: ''}
    }
})


/**
 * --------------------------------------------------------------------------
 * Importa os componentes Vue
 * --------------------------------------------------------------------------
 */
import ExampleComponent from './components/ExampleComponent.vue';
import LoginComponent from './components/Login.vue';
import HomeComponent from './components/Home.vue';
import MarcasComponent from './components/Marcas.vue';
import InputContainer from './components/InputContainer.vue';
import TableContainer from './components/Table.vue';
import CardContainer from './components/Card.vue';
import ModalContainer from './components/Modal.vue';
import AlertComponent from './components/Alert.vue';
import PaginateComponent from './components/Paginate.vue';

/**
 * --------------------------------------------------------------------------
 * Cria a instância principal do Vue
 * --------------------------------------------------------------------------
 */
const app = createApp({});

app.use(store)

/**
 * --------------------------------------------------------------------------
 * Registra os componentes globais
 * --------------------------------------------------------------------------
 */
const components = {
  'example-component': ExampleComponent,
  'login-component': LoginComponent,
  'home-component': HomeComponent,
  'marcas-component': MarcasComponent,
  'input-container-component': InputContainer,
  'table-component': TableContainer,
  'card-component': CardContainer,
  'modal-component': ModalContainer,
  'alert-component': AlertComponent,
  'paginate-component': PaginateComponent,

};

Object.entries(components).forEach(([name, component]) => {
  app.component(name, component);
});

/**
 * --------------------------------------------------------------------------
 * Monta a aplicação no elemento #app
 * --------------------------------------------------------------------------
 */
app.mount('#app');
