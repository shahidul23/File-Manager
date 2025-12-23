export function httpGet(url) {
    return fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'same-origin',
    }).then(response => {
        if (!response.ok) {
            return response.json().then(errorData => {
                const error = new Error('HTTP error ' + response.status);
                error.data = errorData;
                throw error;
            });
        }
        return response.json();
    });
}
