import React from 'react';
import { Api } from '../../../contexts/api';
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import Form from 'react-bootstrap/Form';
import InputGroup from 'react-bootstrap/InputGroup';

const Transacao: React.FC = () => {
    const [modalShow, setModalShow] = React.useState(false);
    const [transferType, setTransferType] = React.useState('');
    const [transferValue, setTransferValue] = React.useState('');

    const handleClose = () => setModalShow(false);
    const handleShow = () => setModalShow(true);
    const handleTransferTypeChange = (event: React.ChangeEvent<HTMLSelectElement>) => {
        setTransferType(event.target.value);
    };

    const handleInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        setTransferValue(event.target.value);
      }

      const handleFormSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
    
        const formattedTransferValue = parseFloat(transferValue).toFixed(2); // Format to 2 decimal places
    
        try {
          const response = await Api.post('/transferencias', {
            valor: formattedTransferValue,
            // Other transfer data as needed
          });
    
          console.log('Transferência enviada com sucesso:', response.data);
          // Handle successful response (show success message, redirect, etc.)
        } catch (error) {
          console.error('Erro ao enviar transferência:', error);
          // Handle errors (show error message, retry logic, etc.)
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
                            placeholder='00,00'
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
                            <Form.Control aria-label="Chave do Pix" placeholder='cpf / email / numero / chave-aleatoria' />
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
                    <Button type='submit' variant="primary" onClick={handleFormSubmit}> 
                        Enviar
                    </Button>
                </Modal.Footer>
            </Modal>
        </>
    );
};

export default Transacao;
