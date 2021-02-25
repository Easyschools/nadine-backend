import store from '../store';

store.subscribe((mutation) => {
    switch (mutation.type) {
        case 'auth/SET_TOKEN':
            if (mutation.payload) {
                axios.defaults.headers.common['Authorization'] =
                    'Bearer ' + mutation.payload;
                console.log('success');

                localStorage.setItem('token',mutation.payload)
            } else {
                axios.defaults.headers.common['Authorization'] = null;
                console.log('fail');
                localStorage.removeItem('token')
            }
            break;
    }
});
