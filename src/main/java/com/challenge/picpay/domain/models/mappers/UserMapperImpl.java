package com.challenge.picpay.domain.models.mappers;

import com.challenge.picpay.domain.models.dto.UserDtoRequest;
import com.challenge.picpay.domain.models.dto.UserDtoResponse;
import com.challenge.picpay.domain.models.entities.User;
import lombok.AllArgsConstructor;
import org.modelmapper.ModelMapper;
import org.springframework.stereotype.Component;

@AllArgsConstructor

@Component
public class UserMapperImpl implements UserMapper {

    private ModelMapper modelMapper;

    @Override
    public User dtoRequestMapperToEntity(UserDtoRequest dto) {
        return modelMapper.map(dto, User.class);
    }

    @Override
    public UserDtoResponse entityMapperToDtoResponse(User entity) {
        return new UserDtoResponse(entity.getId(), entity.getName(), entity.getCode(), entity.getEmail());
    }
}
