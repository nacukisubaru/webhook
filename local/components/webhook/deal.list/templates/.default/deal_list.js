'use strict';
const e = React.createElement;

function DrawDeal(param) {
    let element = '';
    if(param == 'N') {
         element = (
            <div className='deal-error'>В этой стадии нет сделок!</div>
        );
    } else {
        let deals_list = JSON.parse(param);
         element = (
            <div>
                {deals_list.map((item, index) => (
                    <div className='row card-deal'>
                        <div className='col-md-5'>
                            <div className='title-deal'>{item.name} #{item.id}</div>
                            <div className='price'>{item.sum} {item.currency}</div>
                            <div>{item.client.name} {item.client.phone}</div>
                            <div>{item.create}</div>
                            <div>{item.comment}</div>
                        </div>
                        <div className='col-md-7'>
                            {item.products.map((item, index) => (
                                <div>{item.name} | {item.quan} {item.lng} | {item.price}</div>
                            ))}
                        </div>

                    </div>
                ))}
            </div>
        );
    }
    ReactDOM.render(element, document.getElementById('deal_block'));
}

class DealStage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            callDeal: false
        };
    }

    render() {
        if (this.state.callDeal) {
            const stage_id = this.props.stageid;
            const url = this.props.url+'?stage=' + stage_id;
            $.ajax({
                url: url,
                method: 'post',
                success: function (responce) {
                    DrawDeal(responce);
                }
            });

        }
        return (
            <ul className="nav flex-column" id="Menu">
                <li className="nav-item" onClick={() => this.setState({callDeal: true})}>
                    <a className="nav-link active">
                        {this.props.stageid}
                    </a>
                </li>
            </ul>
        );
    }
}

document.querySelectorAll('.deal_stage')
    .forEach(domContainer => {
        const stageid = domContainer.dataset.stageid;
        const url = domContainer.dataset.url;
        ReactDOM.render(
            React.createElement(DealStage, {stageid: stageid,url:url}),
            domContainer
        );
    });