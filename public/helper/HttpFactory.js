class HttpFactory 
{
    async get(url = '') {
        const request = await fetch(url, {
            method: 'GET',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        })

        const response = await request.json();
        return response;
    };

    async post(url = '', data = {}) {
        const request = await fetch(url, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(data)
        })

        const response = await request.json();
        return response;
    };

    async put(url = '', data = {}) {
        const request = await fetch(url, {
            method: 'PUT',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(data)
        })

        const response = await request.json();
        return response;
    };

    async delete(url = '') {
        const request = await fetch(url, {
            method: 'DELETE',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        })

        const response = await request.json();
        return response;
    };
}