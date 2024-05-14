/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../styles/styles.scss';

// start the Stimulus application
//import './bootstrap';

// ./src/js/app.js
    
import React from 'react';
import ReactDOM from 'react-dom';
import { RouterProvider, createBrowserRouter } from 'react-router-dom';
import MovieDetail from './movies/MovieDetail.jsx';
import MoviesList from './movies/movieslist.jsx';

import 'bootstrap/dist/css/bootstrap.min.css';

const router = createBrowserRouter([
    {
        path: "/",
        element: <MoviesList />,
    },
    {
        path: "/movie/:id",
        element: <MovieDetail />,
    }
]);
    
ReactDOM.createRoot(document.getElementById('root')).render(
    <RouterProvider router={ router }/>
);
