package com.challenge.picpay.domain.models.mappers;

import com.challenge.picpay.domain.models.dto.UserDtoRequest;
import com.challenge.picpay.domain.models.dto.UserDtoResponse;
import com.challenge.picpay.domain.models.entities.User;

public interface UserMapper {
    User dtoRequestMapperToEntity(UserDtoRequest dto);
    UserDtoResponse entityMapperToDtoResponse(User entity);
}
