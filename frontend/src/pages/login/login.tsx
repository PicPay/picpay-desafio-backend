import React, { useState } from 'react';
import { useNavigate} from "react-router-dom";
// import { Api } from '../contexts/api';

import Button from 'react-bootstrap/Button';
import Form from 'react-bootstrap/Form';

const Login: React.FC = () => {
    const navigate = useNavigate();
    return (
        <Form>
            <h3>Login</h3>
        <Form.Group className="mb-3" controlId="formBasicEmail">
          <Form.Label>Email</Form.Label>
          <Form.Control type="email" placeholder="Email" />
        </Form.Group>
  
        <Form.Group className="mb-3" controlId="formBasicPassword">
          <Form.Label>Senha</Form.Label>
          <Form.Control type="password" placeholder="Password" />

        <Form.Text className="text-muted">
          Não possuí conta
        </Form.Text>

        </Form.Group>
        <Button variant="primary" type="submit">
          Entrar
        </Button>


      </Form>
    );
};

export default Login;
