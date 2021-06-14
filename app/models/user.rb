class User < ApplicationRecord
  has_secure_password
  enum kind: [ :shopkeeper, :consumer ]

  has_one :wallet, dependent: :destroy

  after_create :create_default_wallet

  validates :email, uniqueness: true
  validates :ssn, uniqueness: true 

  def can_pay?(value)
    self.wallet.balance >= value
  end

  private
  
  def create_default_wallet
    Wallet.create(user_id: self.id, balance: 0.0)
  end
end
