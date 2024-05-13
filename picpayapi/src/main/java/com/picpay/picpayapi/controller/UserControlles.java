package com.picpay.picpayapi.controller;

import java.util.List;

import org.springframework.beans.BeanUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
//import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RestController;

import com.fasterxml.jackson.databind.util.BeanUtil;
import com.picpay.picpayapi.dominio.user.User;
import com.picpay.picpayapi.dtos.UserDto;
import com.picpay.picpayapi.services.UserServices;

@RestController()
@RequestMapping("/users")
public class UserControlles {
    

    @Autowired
    private UserServices userServices;


    @PostMapping()
    public ResponseEntity <User> creaEntity ( @RequestBody UserDto user ){
        User newUser = new User();
        BeanUtils.copyProperties(user, newUser);
        this.userServices.saveUser(newUser);
        return new ResponseEntity<>(newUser,HttpStatus.CREATED);
    
    }

    @GetMapping
    public ResponseEntity<List<User>> getAll(){

        List<User> list = this.userServices.getAllUSer();
        return new ResponseEntity<>(list,HttpStatus.OK);
        //return new ResponseEntity<>(HttpStatus.OK);
      ///  return ResponseEntity.status(HttpStatus.OK).body(list);
        
    }
}
