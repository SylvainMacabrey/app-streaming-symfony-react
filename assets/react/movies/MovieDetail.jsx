import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { getMovie, getSuggestions } from '../api';
import { Badge, Col, Container, Row, Tab, Tabs } from 'react-bootstrap';
import MoviePoster from './MoviePoster';
import YouTube from 'react-youtube';

function MovieDetail() {
    const { id } = useParams();
    const [ movie, setMovie ] = useState({});
    const [ recommendations, setRecommendations ] = useState([]);

    useEffect(() => {
        getMovie(id).then(res => {
            setMovie(res);
        });
        getSuggestions(id).then(res => {
            console.log(res)
            setRecommendations(res);
        });
    }, [id]);

    const categories = () => {
        if (movie.categories !== undefined) {
            return movie.categories.map(category => {
                return (
                    <Badge className='badgeCategory'>{ category.name }</Badge>
                );
            });
        }
    };

    const actors = () => {
        if (movie.actors !== undefined) {
            return movie.actors.join(", ");
        }
    };

    const suggestions = () => {
        const colStyle = { 
            width: '200px',
            height: '300px',
            margin: '10px',
            flex: 'initial'
        };

        if (recommendations.length > 0) {
            return recommendations.map(movie => {
                return (
                    <Col key={movie.id} style={ colStyle }>
                        <MoviePoster movie={movie} />
                    </Col>
                );
            });
        } else {
            return <p style={{ color: "white" }}>No suggestions for this movie</p>
        }
    };

    const opts = {
        height: '390',
        width: '640',
        playerVars: {
          // https://developers.google.com/youtube/player_parameters
          autoplay: 1,
        },
    };

    return (
        <Container style={{ marginTop: '40px' }}>
            <Row>
                <Col xs={5}>
                    <div className='movieTitle'>
                        { movie.title }
                    </div>
                    <div className='movieCategories'>
                        { categories() }
                    </div>
                    <div className='movieDescription'>
                        { movie.description }
                    </div>
                </Col>
                <Col xs={7}>
                    <YouTube videoId={ movie.trailer } opts={ opts } />
                </Col>
            </Row>
            <Row style={{ backgroundColor: '#2c2c44', marginTop: '20px' }}>
                <Tabs defaultActiveKey="details" id="uncontrolled-tab-example" className="mb-3 movieTabs" fill>
                    <Tab eventKey="details" title="Details" className='movieDetail'>
                        <p>Director: { movie.director }</p>
                        <p>Cast: { actors() }</p>
                        <p>Duration: { movie.duration } minutes</p>
                    </Tab>
                    <Tab eventKey="suggestions" title="Suggestions" className='movieSuggestions'>
                        <Row style={{ justifyContent: 'center' }}>
                            { suggestions() }
                        </Row>
                    </Tab>
                </Tabs>
            </Row>
        </Container>
    );
}

export default MovieDetail;