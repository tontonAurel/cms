import preloader from './mixins/preloader.js'
import form from './mixins/form.js'
import moment from 'moment'
import bread from './mixins/bread.js'

const app = new Vue({
    el: '#post-edit',
    mixins: [preloader, form, bread],
    data () {
        return {
            post: {
                'date': moment(window.old.date).format('YYYY-MM-DD') || moment().format('YYYY-MM-DD'),
                'title': window.old.title || '',
                'description': window.old.description,
                medias: window.old.medias
            },
        }
    },
})


