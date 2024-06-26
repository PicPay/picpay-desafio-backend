import React, { useState } from 'react';
import { Api } from '../../../contexts/api';

import { Button, Modal, Form, InputGroup } from 'react-bootstrap';

const Transacao: React.FC = () => {
    const [modalShow, setModalShow] = useState(false);
    const [transferType, setTransferType] = useState('');
    const [transferValue, setTransferValue] = useState('');
    const [pixKey, setPixKey] = useState('');
    const [error, setError] = useState<string | null>(null);

    const handleClose = () => setModalShow(false);
    const handleShow = () => setModalShow(true);

    const handleInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        setTransferValue(event.target.value);
    };

    const handlePixKeyChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        setPixKey(event.target.value);
    };

    const handleTransferTypeChange = (event: React.ChangeEvent<HTMLSelectElement>) => {
        setTransferType(event.target.value);
    };

    const handleTransferSubmit = async () => {
        const formattedTransferValue = transferValue.replace(',', '.');

        try {
            const response = await Api.post('/usuarios/', {
                saldo: formattedTransferValue,
                chave_pix: {
                    cpf: pixKey,
                },
            });

            console.log('Transferência enviada com sucesso:', response.data);
            handleClose();
        } catch (error) {
            if (error.response && error.response.data && error.response.data.saldo) {
                setError(error.response.data.saldo[0]);
            } else {
                setError('Erro ao enviar transferência.');
            }
        }
    };

    return (
        <>
            <Button variant="primary" onClick={handleShow}>
                Fazer Transferência
            </Button>

            <Modal
                show={modalShow}
                onHide={handleClose}
                size="lg"
                aria-labelledby="contained-modal-title-vcenter"
                centered
            >
                <Modal.Header closeButton>
                    <Modal.Title id="contained-modal-title-vcenter">
                        Transferência
                    </Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <InputGroup className="mb-2">
                        <InputGroup.Text>Valor</InputGroup.Text>
                        <InputGroup.Text>R$</InputGroup.Text>
                        <Form.Control
                            aria-label="Valor da transferência"
                            placeholder="00,00"
                            required
                            type="number"
                            value={transferValue}
                            onChange={handleInputChange}
                        />
                    </InputGroup>

                    <Form.Select
                        aria-label="Tipo de Transferência"
                        onChange={handleTransferTypeChange}
                    >
                        <option>Tipo de Transferência</option>
                        <option value="TED">TED e TEF</option>
                        <option value="Pix">Pix</option>
                    </Form.Select>

                    {transferType === 'Pix' && (
                        <InputGroup className="mt-3">
                            <InputGroup.Text>Chave Pix</InputGroup.Text>
                            <Form.Control
                                aria-label="Chave do Pix"
                                placeholder="cpf / email / numero / chave-aleatoria"
                                value={pixKey}
                                onChange={handlePixKeyChange}
                            />
                        </InputGroup>
                    )}

                    {transferType === 'TED' && (
                        <>
                        <InputGroup className="mt-3">
                            <InputGroup.Text>Banco:</InputGroup.Text>
                            <Form.Control aria-label="Banco" placeholder='Banco do destinatário'/>
                        </InputGroup>

                        <InputGroup className="mt-3">
                            <InputGroup.Text>Agência e Conta:</InputGroup.Text>
                            <Form.Control aria-label="Agência e Conta" placeholder='0000 / 00.000000.0' />
                        </InputGroup>
                        
                        <InputGroup className="mt-3">
                            <InputGroup.Text>tipo de conta:</InputGroup.Text>
                            <Button variant="outline-dark">Conta Corrente</Button>
                            <Button variant="outline-dark">Conta Poupança</Button>
                        </InputGroup>

                        </>
                    
                    )}
                </Modal.Body>
                <Modal.Footer>
                    {error && <p style={{ color: 'red' }}>{error}</p>}
                    <Button type="submit" variant="primary" onClick={handleTransferSubmit}>
                        Enviar
                    </Button>
                </Modal.Footer>
            </Modal>
        </>
    );
};

export default Transacao;
