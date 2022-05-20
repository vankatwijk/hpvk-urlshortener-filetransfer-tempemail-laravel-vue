import axios from 'axios'

const getClient = (baseUrl = null) => {

    const options = {
        baseURL: baseUrl,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    }

    const client = axios.create(options)

    let token = document.head.querySelector('meta[name="csrf-token"]')

    if (token) {
        client.defaults.headers.common['X-CSRF-TOKEN'] = token.content
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
    }

    return client
}
const getClientUpload = (baseUrl = null) => {

    const optionsUpload = {
        baseURL: baseUrl,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'multipart/form-data',
            'Accept': 'application/json'
        }
    }

    const client = axios.create(optionsUpload)

    let token = document.head.querySelector('meta[name="csrf-token"]')

    if (token) {
        client.defaults.headers.common['X-CSRF-TOKEN'] = token.content
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
    }

    return client
}

class ApiClient {
    constructor(baseUrl = null) {
        this.client = getClient(baseUrl)
        this.clientUpload = getClientUpload(baseUrl)
    }

    uploadPost(url, data = {}, conf = {}) {
        var formData = new FormData();
        formData.append("file", data.file);
        formData.append("original", data.original);

        return this.clientUpload.post(url, formData, conf)
            .then(response => Promise.resolve(response))
            .catch(error => Promise.reject(error))
    }

    post(url, data = {}, conf = {}) {
        return this.client.post(url, data, conf)
            .then(response => Promise.resolve(response))
            .catch(error => Promise.reject(error))
    }

    get(url, conf = {}) {
        return this.client.get(url, conf)
            .then(response => Promise.resolve(response))
            .catch(error => Promise.reject(error))
    }
}

export { ApiClient }