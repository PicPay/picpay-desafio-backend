package com.picpay.picpayapi.services;

import java.math.BigDecimal;

import java.util.List;
//import java.util.List;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.picpay.picpayapi.dominio.user.User;
import com.picpay.picpayapi.dominio.user.UserType;
import com.picpay.picpayapi.repositories.UserRespository;

@Service
public class UserServices {
    @Autowired
    private UserRespository userRespository;

   // List<User> lista = this.userRespository.findAll();
    

    public void validarTrasferencia(User user, BigDecimal amount) throws Exception{

          //lista.forEach(p->System.out.println(p.getDocument()));
         if(user.getType() == UserType.USER_MERCAHNT){
            throw new Exception("Usuário  do Tipo Logista não pode fazer envios de dinheiro!!");
         }
        if( user.getBalance().compareTo(amount)<0){
            throw new  Exception("NEGADO, saldo insuficienten!");

        }
       
    }

    public User findUserById(Long id)throws  Exception{
        //modelo 1
        return this.userRespository.findUserById(id).orElseThrow (
            //caso não ache lança exeção
              ()->new Exception("User não encontrado")
              );
    }

    public void saveUser( User user){
        this.userRespository.save(user);
    }

   public List<User> getAllUSer(){

    return this.userRespository.findAll();

   }
}
