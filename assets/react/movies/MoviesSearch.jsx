import React, { useState, useEffect } from 'react';
import Form from 'react-bootstrap/Form';
import Dropdown from 'react-bootstrap/Dropdown';
import { getCategories } from '../api';

function MoviesSearch({ title, handleChangeTitle, handleChangeCategories }) {

    const [categories, setCategories] = useState([]);
    const [selectedCategories, setSelectedCategories] = useState([]);

    useEffect(() => {
        getCategories().then(res => {
            setCategories(res);
        })
    }, []);

    const CustomToggle = React.forwardRef(({ children, onClick }, ref) => (
        <a href="" ref={ ref } onClick={(e) => {
            e.preventDefault();
            onClick(e);
          }}
        >
          { children }
          &#x25bc;
        </a>
    ));
    
    const CustomMenu = React.forwardRef(
        ({ children, style, className, 'aria-labelledby': labeledBy }, ref) => {
            const [value, setValue] = useState('');
        
            return (
                <div ref={ ref } style={ style } className={ className } aria-labelledby={ labeledBy }>
                    <Form.Control autoFocus className="mx-3 my-2 w-auto" placeholder="Categories..." onChange={(e) => setValue(e.target.value)} value={ value } />
                    <ul className="list-unstyled">
                        { 
                            React.Children.toArray(children).filter((child) => !value || child.props.children.toLowerCase().startsWith(value.toLowerCase()))
                        }
                    </ul>
                </div>
            );
        },
    );

    const addCategories = (category) => {
        if (!selectedCategories.includes(category)) {
            const newSelectedCategories = [...selectedCategories, category];
            setSelectedCategories(newSelectedCategories);
            handleChangeCategories(newSelectedCategories);
        }
    };

    const removeCategories = (category) => {
        const filteredSelectedKeys = selectedCategories.filter((data) => {
            return data !== category;
        });
        setSelectedCategories(filteredSelectedKeys);
        handleChangeCategories(filteredSelectedKeys);
    };

    const handleClickCategories = (category) => {
        if (selectedCategories.includes(category)) {
            removeCategories(category);
        } else {
            addCategories(category);
        }
    }

    return (
        <Form>
            <Form.Group className="mb-3" controlId="formTitle">
                <Form.Control type="text" placeholder="Enter the title of a movie" value={ title } onChange={ (e) => handleChangeTitle(e.target.value) }/>
            </Form.Group>
        
            <Dropdown autoClose="outside">
                <Dropdown.Toggle as={ CustomToggle } id="dropdown-custom-components">
                    Filter categories
                </Dropdown.Toggle>

                <Dropdown.Menu as={ CustomMenu }>
                    { 
                        categories.map(category => {
                            return (
                                <Dropdown.Item eventKey={ category.id } active={ selectedCategories.includes(category.name) } onClick={ () => handleClickCategories(category.name) }>
                                    { category.name }
                                </Dropdown.Item>
                            );
                        }) 
                    }
                </Dropdown.Menu>
            </Dropdown>
        </Form>
      );
}

export default MoviesSearch;