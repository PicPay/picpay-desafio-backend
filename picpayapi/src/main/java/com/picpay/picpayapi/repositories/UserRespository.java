package com.picpay.picpayapi.repositories;



import java.util.Optional;

import org.springframework.data.jpa.repository.JpaRepository;

import com.picpay.picpayapi.dominio.user.User;

public interface UserRespository extends JpaRepository<User,Long> {

    Optional <User> findUserBydocument(String document);
    Optional <User> findUserById(Long id);
    
}
