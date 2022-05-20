import { ApiClient } from '../client'

let client = new ApiClient(process.env.MIX_APP_URL + '/api')

export default {

    shorten(link) {
        console.log('process.env.MIX_APP_URL', process.env.MIX_APP_URL);

        if (!link.original.startsWith('http://') && !link.original.startsWith('https://')) {
            link.original = 'http://' + link.original
        }

        return client.post('shorten', link)
    },

    upload(link) {
        console.log('process.env.MIX_APP_URL', process.env.MIX_APP_URL);

        return client.post('upload', link.file)
    },

    getAllLinksForUser() {
        return client.get('links')
    }

}