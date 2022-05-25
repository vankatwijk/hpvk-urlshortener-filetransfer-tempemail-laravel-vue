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

        return client.uploadPost('upload', link)
    },

    uploadAvatar(data) {

        return client.uploadPost('upload/avatar', data)
    },

    addRemoveLinkTree(link) {

        return client.post('treelink/addRemove', link)
    },

    saveLinkChanges(link) {

        return client.post('link/saveLinkChanges', link)
    },

    removeLink(link) {

        return client.post('removeLink', link)
    },

    getAllLinksForUser() {
        return client.get('links')
    },

    getAllTreeLinksForUser() {
        return client.get('treelinks')
    },

    getAllClicksForLink(link_id) {
        return client.get('/showclick/' + link_id)
    },

    treeLink() {
        return client.get('treeLink')
    }

}