import { BrowserRouter, Routes, Route } from "react-router-dom";
import AddUser from "./pages/login/add_user";
import Login from "./pages/login/login";
import UserFisico from "./pages/usuarios/PessoaFIsica/userFisico";
import UserJuridico from "./pages/usuarios/PessoaJuridica/userjuridico";

const RoutesApp = () => {
    return (
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Login/>}/>
          <Route path="/cadastro" element={<AddUser/>}/>
          <Route path="/PessoaFisica" element={<UserFisico/>}/>
          <Route path="/PessoaJuridica" element={<UserJuridico/>}/>
        </Routes>
      </BrowserRouter>
    );
  };
  
  export default RoutesApp;