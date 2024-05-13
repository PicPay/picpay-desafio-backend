package com.picpay.picpayapi.dtos;

import java.math.BigDecimal;

import com.picpay.picpayapi.dominio.user.UserType;


public record UserDto(
     String name,
     String document,//cpf e cjnpj
     BigDecimal balance,
     String email,
     String password,

     UserType type
) {
    
}
