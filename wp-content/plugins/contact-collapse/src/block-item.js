import { RichText } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';
import arrow from '../assets/arrow.svg';


const BlockItem = ({ dataId, title, description, contacts, onAddContactBlock, onAddPerson, onChangeTitle, onChangeDescription, onChangeContactName, onChangeContactEmail, onChangeContactPhone, onRemoveBlock, onRemovePerson }) => {
    return (
        <>
            <div className="contact-collapse__item open-collapse" data-id={`contactBlock-${dataId}`} >
                <div className="contact-collapse__item-main">
                    <div class="contact-collapse__item-main-content">
                        <RichText
                            tagName="h3"
                            placeholder="Add block header"
                            value={title}
                            onChange={(title) => onChangeTitle(title, dataId)}
                        />
                        <RichText
                            tagName="p"
                            placeholder="Add block description"
                            value={description}
                            onChange={(description) => onChangeDescription(description, dataId)}
                        />
                    </div>
                    <Button
                        onClick={() => onRemoveBlock(dataId)}
                        className="removeBtn small components-button me-2"
                        variant={'secondary'}
                        isDestructive
                        icon="no-alt"
                    >
                        Remove block
                    </Button>
                    <span className="contact-collapse__item-icon">
                        <img src={arrow} alt="icon" />
                    </span>
                </div>
                <div className="contact-collapse__item-content">
                    <hr />
                    <div className="collapse__item-content">
                        {!!contacts && contacts.length !== 0 && contacts.map(contact => {
                            return (
                                <>

                                    <div className="collapse__item-content--box" data-id={`person-${contact.personId}`}>
                                        <RichText
                                            className="collapse__item-content--title"
                                            tagName="p"
                                            placeholder="Add name"
                                            value={contact.name}
                                            onChange={(contactName) => onChangeContactName('name', contactName, dataId, contact.personId)}
                                        />

                                        <RichText
                                            className="collapse__item-content--text"
                                            tagName="p"
                                            placeholder="Add email"
                                            value={contact.email}
                                            onChange={(contactEmail) => onChangeContactEmail('email', contactEmail, dataId, contact.personId)}
                                        />

                                        <RichText
                                            className="collapse__item-content--text"
                                            tagName="p"
                                            placeholder="Add phone number"
                                            value={contact.phone}
                                            onChange={(contactPhone) => onChangeContactPhone('phone', contactPhone, dataId, contact.personId)}
                                        />
                                        <div className="my-4 d-flex align-items-center">
                                            {contacts.length > 1 && <Button
                                                onClick={() => onRemovePerson(dataId, contact.personId)}
                                                className="removeBtn components-button me-2"
                                                variant={'secondary'}
                                                isDestructive
                                                icon="no-alt"
                                            >
                                                Remove person
                                            </Button>
                                            }
                                            <Button variant={'secondary'} onClick={() => onAddPerson(dataId)}>
                                                Add another person
                                            </Button>
                                        </div>
                                    </div>

                                </>
                            )
                        })}
                    </div>
                </div>
            </div>
            <Button variant={'secondary'} className="mb-5" onClick={onAddContactBlock}>
                Add another contact block
            </Button>
        </>
    )
}

export default BlockItem;