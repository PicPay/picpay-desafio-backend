class UserSerializer < ActiveModel::Serializer
  has_one :wallet
  attributes :id, :name, :email, :ssn, :wallet
end
