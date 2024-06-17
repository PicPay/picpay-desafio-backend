import React, { useState } from 'react';
import { Api } from '../../contexts/api';

import Button from 'react-bootstrap/Button';
import Col from 'react-bootstrap/Col';
import Form from 'react-bootstrap/Form';
import InputGroup from 'react-bootstrap/InputGroup';
import Row from 'react-bootstrap/Row';

const AddUser: React.FC = () => {
    const [userName, setUserName] = useState<string>('');
    const [userCpf_Cnpj, setUserCpf_Cnpj] = useState<string>('');
    const [email, setEmail] = useState<string>('');
    const [tipousuario, setTipousuario] = useState<number>(0);
    const [errorMessage, setErrorMessage] = useState<string>('');

    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        switch (name) {
            case 'Nome':
                setUserName(value);
                break;
            case 'cpf_cnpj':
                setUserCpf_Cnpj(value);
                break;
            case 'email':
                setEmail(value);
                break;
            default:
                break;
        }
    };

    const handleTipoUsuarioChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        setTipousuario(parseInt(e.target.value, 10)); // Convert value to number
    };

    const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        
        try {
            const response = await Api.post('/usuarios/', {
                nome: userName,
                cpf_cnpj: userCpf_Cnpj,
                email: email,
                tipo_usuario: tipousuario,
            });
            console.log('Usuário cadastrado com sucesso:', response.data);
            // Optionally, update your local state or fetch users again after successful submission
        } catch (error) {
            console.error('Erro ao cadastrar usuário:', error);
            if (error.response && error.response.data && error.response.data.cpf_cnpj || error.response.data.email ) {
                setErrorMessage("Cpf ou e-mail já cadastrado");
            } else {
                setErrorMessage('Erro ao cadastrar usuário. Por favor, tente novamente mais tarde.');
            }
        }
    }
    return (
        <Form onSubmit={handleSubmit} noValidate>
            <Form.Group as={Row} className="mb-3" controlId="validationFormik01">
                <Form.Label column sm={2}>Nome: </Form.Label>
                <Col sm={10}>
                    <Form.Control
                        type="text"
                        name="Nome"
                        value={userName}
                        onChange={handleInputChange}
                        placeholder='Nome Completo'
                        required                        
                    />
                </Col>
            </Form.Group>

            <Form.Group as={Row} className="mb-3" controlId="validationFormikUsername">
                <Form.Label column sm={2}>Cpf/Cnpj</Form.Label>
                <Col sm={10}>
                    <InputGroup hasValidation>
                        <Form.Control
                            type="text"
                            name="cpf_cnpj"
                            value={userCpf_Cnpj}
                            onChange={handleInputChange}
                            placeholder='Cpf ou Cnpj'
                            required                                 
                        />
                    </InputGroup>
                </Col>
            </Form.Group>

            <Form.Group as={Row} className="mb-3" controlId="validationFormik03">
                <Form.Label column sm={2}>Email</Form.Label>
                <Col sm={10}>
                    <Form.Control
                        type="email"
                        name="email"
                        value={email}
                        onChange={handleInputChange}
                        placeholder='E-mail'
                        required   
                    />
                </Col>
            </Form.Group>

            <Form.Group as={Row} controlId="formGridState">
                <Form.Label column sm={2}>Tipo de Usuário</Form.Label>
                <Col sm={10}>
                    <Form.Select
                        value={tipousuario}
                        onChange={handleTipoUsuarioChange}
                        aria-label="Selecione o tipo de usuário"
                        required
                    >
                        <option>Selecione</option>
                        <option value="1">Pessoa Física</option>
                        <option value="2">Pessoa Jurídica</option>
                    </Form.Select>
                </Col>
            </Form.Group>

            {errorMessage && (
                <Form.Group as={Row} className="mb-3">
                    <Col sm={{ span: 10, offset: 2 }}>
                        <div className="text-danger">{errorMessage}</div>
                    </Col>
                </Form.Group>
            )}

            <Button type="submit">Cadastrar</Button>
        </Form>
    );
};

export default AddUser;
