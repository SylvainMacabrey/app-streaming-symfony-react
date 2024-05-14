import React, { useState, useEffect } from 'react';
import { getMovies } from '../api';
import MoviesSearch from './MoviesSearch';

import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import MoviePoster from './MoviePoster';

function MoviesList() {
    
    const [movies, setMovies] = useState([]);
    const [title, setTitle] = useState("");
    const [categories, setCategories] = useState("");

    useEffect(() => {
        getMovies(title, categories).then(res => {
            setMovies(res);
        })
    }, [title, categories]);

    const handleChangeTitle = (titleValue) => {
        setTitle(titleValue);
    }

    const handleChangeCategories = (categoriesValue) => {
        setCategories(categoriesValue.join(","));
    }

    const colStyle = { 
        width: '200px',
        height: '300px',
        margin: '10px',
        flex: 'initial'
    };

    return (
        <Container style={{ marginTop: '20px' }}>
            <MoviesSearch 
                title={ title } 
                handleChangeTitle={ handleChangeTitle }  
                handleChangeCategories={ handleChangeCategories }
            />
            <Container>
                <Row style={{ justifyContent: 'center' }}>
                    { 
                        movies.map(movie => {
                            return (
                                <Col key={movie.id} style={ colStyle }>
                                    <MoviePoster movie={movie} />
                                </Col>
                            );
                        }) 
                    }
                </Row>
            </Container>
        </Container>
    );
}

export default MoviesList;