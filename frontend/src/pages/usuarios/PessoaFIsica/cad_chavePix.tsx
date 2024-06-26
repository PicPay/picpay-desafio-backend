import React from 'react';

import { Button, Modal } from 'react-bootstrap';

const CadChavePix: React.FC = () => {
    const [modalShow, setModalShow] = React.useState(false);

    const handleClose = () => setModalShow(false);
    const handleShow = () => setModalShow(true);

    return (
        <>
            <Button variant="primary" onClick={handleShow}>
                Cadastrar Chave
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
                        Cadastro de Chave Pix
                    </Modal.Title>
                </Modal.Header>
                <Modal.Body>
                </Modal.Body>
                <Modal.Footer>
                    <Button type="submit" variant="primary">
                        Cadastrar
                    </Button>
                </Modal.Footer>
            </Modal>
        </>
    );
};

export default CadChavePix;
