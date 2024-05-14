import React, { useState, useEffect } from 'react';
import Card from 'react-bootstrap/Card';
import Badge from 'react-bootstrap/Badge';
import { Link } from 'react-router-dom';

function MoviePoster({movie}) {

    const imgStyle = {
        width: '200px',
        height: '300px'
    };

    const cardStyle = imgStyle;

    const badgeStyle = {
        position: 'absolute',
        top: '10px',
        padding: '10px',
        borderRadius: '0px 10px 10px 0px'
    };

    const categories = () => {
        const result = movie.categories.map(category => category.name);
        return result.slice(0, 2).join(", ");
    }

    return (
        <> 
            <Link to={`/movie/${ movie.id }`}>
                <Card style={ cardStyle }>
                    <Card.Img src={ movie.thumbnail } style={ imgStyle } />
                    <Badge bg="secondary" style={ badgeStyle }>{ categories() }</Badge>
                </Card>
            </Link>
        </>
    );
  }
  
  export default MoviePoster;

