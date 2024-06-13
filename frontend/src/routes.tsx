import { BrowserRouter, Routes, Route } from "react-router-dom";
import AddUser from "./pages/add_user";
import Login from "./pages/login/login";

const RoutesApp = () => {
    return (
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Login/>}/>
          <Route path="/adicionar_usuario" element={<AddUser/>}/>
        </Routes>
      </BrowserRouter>
    );
  };
  
  export default RoutesApp;