const axios = require('axios');

export async function getMovies(title, categories) {
    try {
        const response = await axios.get(`/api/movies?title=${title}&categories=${categories}`);
        return response.data;
    } catch (err) {
        throw new Error(err);
    }
}

export async function getMovie(id) {
    try {
        const response = await axios.get(`/api/movies/${id}`);
        return response.data;
    } catch (err) {
        throw new Error(err);
    }
}

export async function getSuggestions(id) {
    try {
        const response = await axios.get(`/api/movies/${id}/suggestions`);
        return response.data;
    } catch (err) {
        throw new Error(err);
    }
}

export async function getCategories() {
    try {
        const response = await axios.get(`/api/categories`);
        return response.data;
    } catch (err) {
        throw new Error(err);
    }
}

