class Wallet < ApplicationRecord
  belongs_to :user

  def increase_balance(amount)
    self.update!(balance: self.balance += amount)
  end

  def decrease_balance(amount)
    self.update!(balance: self.balance -= amount)
  end
end
