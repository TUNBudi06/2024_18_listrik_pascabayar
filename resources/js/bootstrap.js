import axios from 'axios';
import {Alpine, Livewire} from '../../vendor/livewire/livewire/dist/livewire.esm';

import collapse from '@alpinejs/collapse'

window.Alpine = Alpine;
Alpine.plugin(collapse)

Alpine.directive('clipboard', (el) => {
    console.log(el)
    let text = el.textContent

    el.addEventListener('click', () => {
        navigator.clipboard.writeText(text)
    })
})

Livewire.start()
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
