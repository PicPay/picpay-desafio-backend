class TransactionsController < ApplicationController
  def exchange
    params.permit!
    data = params.to_h
    sender = User.find_by(email: data['from']['email'])
    receiver = User.find_by(email: data['to']['email'])
    amount = data['from']['amount'].to_f

    if !sender.can_pay?(amount) && authorized?
      render json: {'message': 'Sender has not enough funds.'}
    else
      begin
        unless sender.shopkeeper?
          sender.wallet.decrease_balance(amount)
  
          receiver.wallet.increase_balance(amount)

          NotificationService.new.call # send SMS
          
          Transaction.create!(senderId: sender.id, receiverId: receiver.id, value: amount)
          
          render json: {'message': 'The ammount was exchanged successfully.'}, status: :ok
        else
          render json: {'message': 'The sender cannot be a shopkeeper.'}, status: :ok
        end
      rescue
        render json: {'message': 'There was an error. Check the transaction payload.'}, status: :forbidden
      end
    end
  end

  private

  def authorized?
    AuthorizerService.new.call.body.include? 'Success'
  end
end
