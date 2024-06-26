import React from 'react';
import { Link, useNavigate  } from "react-router-dom";

import Button from 'react-bootstrap/Button';
import Form from 'react-bootstrap/Form';
import { Card } from 'react-bootstrap';

const Login: React.FC = () => {

    const navigate = useNavigate();

    const handleLoginSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        navigate('/PessoaFisica');
    };

  return (
    <div style={{display: 'flex', justifyContent: 'center', alignItems: 'center', height: '80vh'
    }}>
        <Card style={{ width: '30rem' }}>
            <Card.Body>
                <Form onSubmit={handleLoginSubmit}>
                    <h3>Login</h3>
                    <Form.Group className="mb-3" controlId="formBasicEmail">
                        <Form.Label>Email</Form.Label>
                        <Form.Control type="email" placeholder="Email" />
                    </Form.Group>

                    <Form.Group className="mb-3" controlId="formBasicPassword">
                        <Form.Label>Senha</Form.Label>
                        <Form.Control type="password" placeholder="Password" />

                        <Form.Text className="text-muted">
                            Não possui conta? <Link to="/cadastro">Cadastre-se aqui!</Link>
                        </Form.Text>
                    </Form.Group>
                    <Button variant="primary" type="submit">
                        Entrar
                    </Button>
                </Form>
            </Card.Body>
        </Card>
    </div>
);
};

export default Login;
