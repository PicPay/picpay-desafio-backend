class TransactionsController < ApplicationController
  def exchange
    begin
      params.permit!
      data = params.to_h

      sender = User.find_by(email: data['from']['email'])
      sender.wallet.decrease_balance(data['from']['amount'].to_f)

      receiver = User.find_by(email: data['to']['email'])
      receiver.wallet.increase_balance(data['from']['amount'].to_f)

      render json: {'message': 'The ammount was exchanged successfully.'}, status: :ok
    rescue
      render json: {'message': 'There was an error. Check the transaction payload.'}, status: :forbidden
    end
  end
end
