import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

// Opcional: Registrar componentes globais
// app.component('example-component', ExampleComponent);

// Vincular à div onde o Vue será usado
app.mount('#app');
